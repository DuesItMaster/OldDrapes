# Integración con CRM (DuesIntegradorCRM)

Documento de referencia sobre cómo **Dues Drapes** envía cotizaciones al cotizador/SAP y a **Zoho CRM** a través del servicio **DuesIntegradorCRM**, para replicar la integración en otro proyecto.

> Basado en el código de `drapes_241025` (`html/cotizar/Pedido.php` y `html/fnc/*`) y en envíos reales registrados en la tabla `Log_enviado_Sincronizador`.

---

## 1. Arquitectura

```
Navegador (Pedido.php)
   │
   ├─ POST /Cotizacion/GetUsuarios ──▶ DuesIntegradorCRM ──▶ (lista de ejecutivos)
   │
   └─ POST /Cotizacion/AddDrapes ───▶ DuesIntegradorCRM ──┬─▶ Cotizador / SAP
                                                          └─▶ Zoho CRM (oportunidad)
   │
   ├─ POST ../fnc/AutorizarPedido.php  (marca la cotización como enviada)
   └─ POST ../fnc/logPedido.php        (bitácora de envío y respuesta)
```

- **DuesIntegradorCRM** es un servicio externo (no vive en este repositorio).
- URL base actual: `http://189.199.126.254:8086/DuesIntegradorCRM/`
  (alternativa interna comentada en el código: `http://192.168.1.20/DuesIntegradorCRM/`).
- **La llamada la hace el navegador** (jQuery), no el servidor PHP.
- El vínculo cotización ↔ Zoho se guarda en la tabla `cotizacion_crm`. **Ningún archivo de Drapes escribe en esa tabla**; la llena un proceso externo (probablemente el propio integrador o Zoho). Drapes solo la lee.

---

## 2. Endpoints

### 2.1 `POST /Cotizacion/GetUsuarios`

Devuelve los ejecutivos de venta para el combo "Ejecutivo de Venta".

**Petición**
- Cuerpo vacío (`$.post(url, {}, ...)`), `Content-Type: application/x-www-form-urlencoded`.

**Respuesta** (JSON, arreglo):
```json
[
  { "Siglas": "HOHH" },
  { "Siglas": "SDM" }
]
```
Drapes solo usa la propiedad `Siglas` (valor y texto del `<option>`). El objeto puede traer más campos.

### 2.2 `POST /Cotizacion/AddDrapes`

Registra la cotización en el cotizador y actualiza la oportunidad en Zoho CRM.

**Formato de la petición (importante)**
- Método: `POST`
- Cuerpo: **texto JSON** (`JSON.stringify(objeto)`), en una sola línea.
- Cabecera: `Content-Type: application/x-www-form-urlencoded; charset=UTF-8` (el valor por defecto de jQuery; **no** se envía `application/json`).
- El integrador lee el *raw body* y lo deserializa como JSON.
- Al usar `x-www-form-urlencoded` el navegador no hace *preflight* CORS (`OPTIONS`). Si el nuevo proyecto envía `application/json` desde el navegador, el integrador debe responder el preflight; si se llama **servidor a servidor**, no aplica.

Petición equivalente:
```
POST /DuesIntegradorCRM/Cotizacion/AddDrapes HTTP/1.1
Host: 189.199.126.254:8086
Content-Type: application/x-www-form-urlencoded; charset=UTF-8

{"Nombre":"Cotizacion Drapes Folio: 30024","Origen":2,...,"DetalleCotizacion":[...]}
```

**Respuesta exitosa** (JSON):
```json
{ "Id_CotGral": 5278, "idUsuario": 14, "respuesta": "Error al Actualizar en CRM" }
```

**Respuesta con error** (JSON):
```json
{ "error": "…favor de revisar los valores" }
```

Drapes considera éxito **si y solo si** la respuesta trae `Id_CotGral`. La respuesta debe venir con `Content-Type: application/json` para que jQuery la convierta en objeto.

---

## 3. Estructura del JSON de `AddDrapes`

### 3.1 Cabecera

| Campo | Tipo enviado | Origen en Drapes | Descripción |
|---|---|---|---|
| `Nombre` | string | `"Cotizacion Drapes Folio: " + id` | Nombre de la cotización |
| `Origen` | número | fijo `2` | Identifica el sistema origen (2 = Drapes) |
| `CodigoCliente` | string | `usuario.CLAVESAP` (si está vacío: `"00127"`) | Código de cliente en SAP |
| `ImporteGral` | string | `cotizacion.Subtotal` | Importe general |
| `DescuentoGral` | número | fijo `0` | Descuento general |
| `SubtotalGral` | string | `cotizacion.Subtotal` | Subtotal |
| `IVAGral` | string | `cotizacion.Iva` | IVA |
| `TotalGral` | string | `cotizacion.Total` | Total |
| `username` | string | Siglas elegidas en el combo (de `GetUsuarios`) | Ejecutivo de venta |
| `idCRM` | string | `cotizacion_crm.idcrm` | ID del registro en Zoho |
| `IdOfertaVentaSAP` | string | `cotizacion_crm.oportunidad` | ID de la oportunidad (Potential) en Zoho |
| `folioDrapes` | string | `cotizacion.id_cotizacion` | Folio en el sistema origen |
| `DetalleCotizacion` | arreglo | Partidas (ver 3.2) | Detalle |

> Los importes viajan como **strings** con 3 decimales (`"9924.738"`). `Origen` y `DescuentoGral` van como números.

### 3.2 Partidas (`DetalleCotizacion[]`)

Cada partida lleva **todos** los campos siguientes; los que no aplican al tipo de producto van vacíos (`""`), en `0` o `null`.

**Generales**

| Campo | Descripción |
|---|---|
| `tipoProducto` | `CORTINA`, `CORTINERO`, etc. |
| `Codigo` | Código del artículo/confección |
| `TituloCortina` | Descripción legible de la partida |
| `Cantidad` | Cantidad |
| `Descuento` | % de descuento de la partida |
| `Importe` | Importe de la partida |
| `PrecioUnitario` | Precio unitario |
| `Descripcion` | Descripción corta |
| `Cargos` | Cargos adicionales |

**Tela**: `Tela`, `PrecioTela`, `ImporteTela`, `CodigoTela`, `AnchoTela`, `TipoTela`, `DescuentoTela`, `Lienzos`, `Metraje`, `TotalMetraje`

**Medidas**: `AnchoCortina`, `AltoCortina`, `Hojas`

**Mano de obra**: `Mo`, `MoCodigo`, `MoPrecio`, `MoImporte`, `MoEstilo`, `MoCalculo`, `MoBastilla`, `MoFactPlizaj`, `MoFactDesp`, `MoDescuento`, `TotalMo`

**Mano de obra cargo extra (> 3 m)**: `Mo3Mts`, `MetrajeMo3Mts`, `PrecioMo3Mts`, `DescuentoMo3Mts`

**Forro**: `ForroTela`, `ForroCodigo`, `ForroPrecio`, `ForroAnchoTela`, `ForroLienzos`, `ForroMetraje`, `ForroDescuento`, `ForroPrecioFinal`, `CodigoMoForro`, `TotalMoForro`, `PrecioFinalMoForro`, `PRECIOMOFORRO`, `DESCUENTOMOFORRO`

**Bajo plomo**: `PrecioPlomo`, `MetrajeBajoPlomo`, `CodigoBajoPlomo`, `DescuentoBajoPlomo`, `ImporteBajoPlomo`

**Stiffener**: `CodigoStiffener`, `PrecioStiffener`, `importeStiffener`

**Cortinero / kit**: `COMODINCORTINERO`, `PRECIOUNITARIOKITCORTINERO`, `IMPORTEKITCORTINERO`

**Bastón**: `BASTON` (0/1), `CODIGOBASTON`, `PRECIOBASTONUNITARIO`, `IMPORTEBASTON`, `CANTIDADBASTON`, `DESCRIPCIONBASTON`

> Los nombres de campo distinguen mayúsculas/minúsculas y mezclan estilos (`importeStiffener`, `PRECIOMOFORRO`). Hay que respetarlos tal cual.

---

## 4. Ejemplo real (folio 30024)

Envío registrado el 8 de mayo de 2026 en `Log_enviado_Sincronizador`.

<details>
<summary>JSON completo enviado</summary>

```json
{
  "Nombre": "Cotizacion Drapes Folio: 30024",
  "Origen": 2,
  "CodigoCliente": "37201",
  "ImporteGral": "9924.738",
  "DescuentoGral": 0,
  "SubtotalGral": "9924.738",
  "IVAGral": "1587.960",
  "TotalGral": "11512.700",
  "username": "HOHH",
  "idCRM": "4602998000205008013",
  "IdOfertaVentaSAP": "4602998000205022002",
  "folioDrapes": "30024",
  "DetalleCotizacion": [
    {
      "tipoProducto": "CORTINA",
      "Codigo": "CORPLIPOR",
      "TituloCortina": "CORTINA PLITZ PORTUGUES TELA: CLOUD COLOR: BEIGE MED: 8.00 X 2.56 2H A TECHO",
      "Cantidad": "1",
      "Tela": "CLOUD",
      "PrecioTela": "354.380",
      "ImporteTela": "4762.87",
      "CodigoTela": "DT-300-CLOUD-BEIGE",
      "AnchoTela": "3",
      "AnchoCortina": "8.00",
      "AltoCortina": "2.56",
      "Hojas": 2,
      "TipoTela": "BLACOUT",
      "DescuentoTela": 40,
      "Mo": "Mano de Obra MICROFLEX",
      "MoCodigo": "MOFLEX2.80R",
      "MoPrecio": "515.340",
      "MoImporte": "2164.43",
      "MoEstilo": "PLITZ FRANCES / ESPANOL",
      "MoCalculo": "ML",
      "MoBastilla": null,
      "MoFactPlizaj": null,
      "MoFactDesp": null,
      "MoDescuento": 40,
      "ForroTela": "",
      "ForroCodigo": "",
      "ForroPrecio": "0.000",
      "ForroAnchoTela": null,
      "ForroLienzos": "0.000",
      "ForroMetraje": "0.00",
      "ForroDescuento": 40,
      "ForroPrecioFinal": "0.000",
      "Lienzos": "7.000",
      "TotalMo": "7.00",
      "Metraje": "22.400",
      "TotalMetraje": "22.40",
      "Cargos": "0",
      "Descuento": 40,
      "Importe": "6927.29",
      "PrecioUnitario": "6927.29",
      "Descripcion": "",
      "PrecioPlomo": "36.420",
      "MetrajeBajoPlomo": 0,
      "CodigoBajoPlomo": "RW-COR-PLOMO-LW80",
      "DescuentoBajoPlomo": "RW-COR-PLOMO-LW80",
      "Mo3Mts": "MOFLEX2.80R",
      "MetrajeMo3Mts": 0,
      "PrecioMo3Mts": 0,
      "DescuentoMo3Mts": 40,
      "CodigoStiffener": "",
      "PrecioStiffener": "0.000",
      "importeStiffener": "0.00",
      "CodigoMoForro": "",
      "ImporteBajoPlomo": "",
      "TotalMoForro": "0.00",
      "PrecioFinalMoForro": "0.00",
      "PRECIOMOFORRO": "",
      "DESCUENTOMOFORRO": 40,
      "COMODINCORTINERO": "",
      "PRECIOUNITARIOKITCORTINERO": 0,
      "IMPORTEKITCORTINERO": 0,
      "BASTON": 0,
      "CODIGOBASTON": "",
      "PRECIOBASTONUNITARIO": 0,
      "IMPORTEBASTON": 0,
      "CANTIDADBASTON": 0,
      "DESCRIPCIONBASTON": ""
    },
    {
      "tipoProducto": "CORTINERO",
      "Codigo": "CNHITN-33",
      "TituloCortina": "CORTINERO CS COLOR: NEGRO MED 4.00 1H  CONTROL DERECHA A TECHO ",
      "Cantidad": "2",
      "Tela": "",
      "PrecioTela": "0.000",
      "ImporteTela": 0,
      "CodigoTela": "",
      "AnchoTela": 0,
      "AnchoCortina": "4.00",
      "AltoCortina": 0,
      "Hojas": 1,
      "TipoTela": "",
      "DescuentoTela": 0,
      "Mo": "",
      "MoCodigo": "",
      "MoPrecio": "0.000",
      "MoImporte": 0,
      "MoEstilo": "",
      "MoCalculo": "",
      "MoBastilla": "",
      "MoFactPlizaj": "",
      "MoFactDesp": "",
      "MoDescuento": "",
      "ForroTela": "",
      "ForroCodigo": "",
      "ForroPrecio": "0.000",
      "ForroAnchoTela": 0,
      "ForroLienzos": "0.000",
      "ForroMetraje": "0.000",
      "ForroDescuento": 0,
      "ForroPrecioFinal": "0.000",
      "Lienzos": "0.000",
      "TotalMo": 0,
      "Metraje": "0.000",
      "TotalMetraje": 0,
      "Cargos": "0",
      "Descuento": 40,
      "Importe": "2588.28",
      "PrecioUnitario": "2156.90",
      "Descripcion": "CORTINERO CS",
      "PrecioPlomo": "",
      "MetrajeBajoPlomo": 0,
      "CodigoBajoPlomo": "",
      "DescuentoBajoPlomo": "",
      "Mo3Mts": "",
      "MetrajeMo3Mts": "",
      "PrecioMo3Mts": "",
      "DescuentoMo3Mts": "",
      "CodigoStiffener": "",
      "PrecioStiffener": "",
      "importeStiffener": "",
      "CodigoMoForro": "",
      "ImporteBajoPlomo": "",
      "TotalMoForro": "",
      "PrecioFinalMoForro": "",
      "PRECIOMOFORRO": "",
      "DESCUENTOMOFORRO": "",
      "COMODINCORTINERO": "CA-CORTINERO",
      "PRECIOUNITARIOKITCORTINERO": "2997.44",
      "IMPORTEKITCORTINERO": "2997.44",
      "BASTON": 1,
      "CODIGOBASTON": "FG-150-BAIMP-NEGRO",
      "PRECIOBASTONUNITARIO": 340.97,
      "IMPORTEBASTON": 409.164,
      "CANTIDADBASTON": "2",
      "DESCRIPCIONBASTON": "BASTON COLOR: NEGRO MATERIAL: FIBRA DE VIDRIO"
    }
  ]
}
```

</details>

**Respuesta recibida**
```json
{ "Id_CotGral": 5278, "idUsuario": 14, "respuesta": "Error al Actualizar en CRM" }
```

---

## 5. Qué hace Drapes después del envío

**Si hay `Id_CotGral` (éxito):**
1. Muestra `Id_CotGral`, `idUsuario` y `respuesta` en pantalla, y desactiva el botón para que no se envíe dos veces.
2. `fnc/AutorizarPedido.php`:
   - `cotizacion`: `ESTADO = 3`, `IdCotizador = Id_CotGral`, `IdUsuarioCotizador = idUsuario`, `FECHA_COTIZADOR = ahora`, `EJECUTIVO_COTIZADOR = username`.
   - `Cotizacion_Gen.Estatus = 'AUTORIZADO'`.
3. `fnc/logPedido.php`: inserta en `Log_enviado_Sincronizador` (`created`, `folio`, `usuario`, `nombre`, `datos` = JSON enviado, `respuesta` = JSON recibido).

**Si no hay `Id_CotGral`:** muestra `content.error` y lo registra en el log. Si falla la conexión, aparece "No se pudo grabar la cotizacion".

**Para evitar reenvíos:** al cargar la página, `fnc/ConsultarEstadoCotizacion.php` revisa si la cotización ya tiene `IdCotizador`; si lo tiene, desactiva el botón.

**Enlace a Zoho** (reportes): `https://crm.zoho.com/crm/org722017379/tab/Potentials/<oportunidad>`

---

## 6. Tablas involucradas

| Tabla | Uso |
|---|---|
| `cotizacion_crm` | `id`, `idcrm`, `oportunidad`, `fecha`, `id_cotizacion`. Vínculo con Zoho. Se llena desde fuera de Drapes. |
| `cotizacion` | Cabecera. Guarda `IdCotizador`, `IdUsuarioCotizador`, `ESTADO`, `EJECUTIVO_COTIZADOR`. |
| `cotizacion_detalle` | Partidas con las que se arma `DetalleCotizacion`. |
| `Cotizacion_Gen` | `Estatus = 'AUTORIZADO'` tras el envío. |
| `Log_enviado_Sincronizador` | Bitácora de cada envío y su respuesta. |

---

## 7. Hallazgos y riesgos detectados

1. **CRM siempre falla según el log:** los 5,755 envíos con `Id_CotGral` registrados (el último del 2026-05-08) responden `"Error al Actualizar en CRM"`. Drapes lo toma como éxito porque solo revisa `Id_CotGral`. Hay que confirmar con el integrador si de verdad falla la actualización en Zoho o si el texto está fijo.
2. **Errores de validación:** 16 envíos sin `Id_CotGral` con el mensaje "…favor de revisar los valores" (el último del 2026-03-20).
3. **Content-Type inconsistente:** el cuerpo es JSON, pero se declara `x-www-form-urlencoded`.
4. **Llamada desde el navegador a una IP pública por HTTP:** se expone el endpoint, no hay autenticación visible y el navegador lo bloquea si el sitio corre en HTTPS (*mixed content*).
5. **Errores de datos en Drapes:**
   - `DescuentoBajoPlomo` lleva el código del plomo en lugar de un porcentaje.
   - `ConsultarEstadoCotizacion.php` asigna `IdUsuarioCotizador = IdCotizador`.
   - `AutorizarPedido.php` usa `$idUsuario`, que nunca se envía; `ID_USUARIO_COTIZADOR` queda vacío.
   - `logPedido.php` guarda la hora con `h` (12 horas, sin AM/PM).
6. **SQL concatenado con `$id`:** permite inyección SQL.

---

## 8. Recomendaciones para el nuevo proyecto

- **Llamar al integrador desde el backend** (servidor a servidor), no desde el navegador. Así se evitan CORS y *mixed content* y no se expone la URL.
- **Enviar `Content-Type: application/json`**, si el integrador lo acepta. Si no, replicar el formato actual (JSON crudo con `x-www-form-urlencoded`).
- **Distinguir los tres resultados:** creado en el cotizador (`Id_CotGral`), actualizado en el CRM (`respuesta`) y error (`error`). No basta con revisar `Id_CotGral`.
- **Obtener `idCRM` y `oportunidad`** antes de enviar. Definir quién llena el equivalente a `cotizacion_crm` en el nuevo sistema.
- **Usar un valor propio de `Origen`** (Drapes usa `2`), acordado con el responsable del integrador.
- **Mandar todos los campos de cada partida**, aunque vayan vacíos. No se sabe si el integrador tolera que falten.
- **Mantener una bitácora** del JSON enviado y la respuesta, como `Log_enviado_Sincronizador`, con la hora en formato de 24 horas.
- **Implementar idempotencia:** guardar el `Id_CotGral` devuelto y no volver a enviar si ya existe.

### Esqueleto mínimo (PHP, servidor a servidor)

```php
$payload = [
    'Nombre'           => "Cotizacion MiProyecto Folio: $folio",
    'Origen'           => 3,               // acordar valor con el integrador
    'CodigoCliente'    => $claveSAP,
    'ImporteGral'      => number_format($subtotal, 3, '.', ''),
    'DescuentoGral'    => 0,
    'SubtotalGral'     => number_format($subtotal, 3, '.', ''),
    'IVAGral'          => number_format($iva, 3, '.', ''),
    'TotalGral'        => number_format($total, 3, '.', ''),
    'username'         => $siglasEjecutivo,
    'idCRM'            => $idCrm,
    'IdOfertaVentaSAP' => $oportunidad,
    'folioDrapes'      => (string)$folio,
    'DetalleCotizacion'=> $partidas,
];

$ch = curl_init('http://189.199.126.254:8086/DuesIntegradorCRM/Cotizacion/AddDrapes');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
    CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded; charset=UTF-8'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 30,
]);
$raw = curl_exec($ch);
$resp = json_decode($raw, true);

if (isset($resp['Id_CotGral'])) {
    // guardar Id_CotGral / idUsuario; revisar $resp['respuesta'] para el estado en CRM
} else {
    // error: $resp['error'] ?? $raw
}
// registrar $payload y $raw en bitácora
```

---

## 9. Pendientes por confirmar con el responsable del integrador

- ¿Qué valores de `Origen` existen y cuál le toca al nuevo proyecto?
- ¿Hay autenticación (token, API key) o una URL distinta para producción y pruebas?
- ¿Qué campos de `DetalleCotizacion` son obligatorios?
- ¿Qué significa exactamente `"Error al Actualizar en CRM"` y cuál es la respuesta cuando sí se actualiza?
- ¿Quién llena `cotizacion_crm` (idcrm y oportunidad) y cómo se haría en el nuevo sistema?
- ¿Acepta `Content-Type: application/json`?
