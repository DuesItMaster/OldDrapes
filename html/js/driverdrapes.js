function initDriver() {
  const steps = [];

  // Este step solo aparece en cortinero.php
  if (document.querySelector('#easywave_item')) {
    steps.push({
      element: '#easywave_item',
      popover: {
        title: 'Nuevo! Cortinero CS EasyWave',
        description: 'Los cortineros CS, CS Ondulado y CS EasyWave ahora se cotizan cada uno en su propia sección.',
        side: 'right',
        align: 'start',
      }
    });
  }

  // Este step solo aparece en easywave.php
  if (document.querySelector('#easywave_item2')) {
    steps.push({
      element: '#easywave_item2',
      popover: {
        title: 'Nuevo! Tipo de sistema',
        description: "Aquí puedes elegir entre las tres opciones de cortinero: <ul><li><b>CS = Estándar</b></li><li><b>ONDULADO = Cortinero CS Ondulado</b></li><li><b>EASYWAVE = Nuevo! Cortinero CS EasyWave</b></li></ul>",
        side: 'bottom',
        align: 'start',
      }
    });
  }

  if (steps.length === 0) return;

  // Verificar cookie antes de mostrar
  /*const COOKIE_KEY = 'tutorial_drapes';
  const yaVisto = document.cookie.split('; ').some(c => c === `${COOKIE_KEY}=true`);
  if (yaVisto) return;*/

  const driverObj = window.driver.js.driver({
    allowClose: true,
    overlayClick: 'next',
    doneBtnText: 'Cerrar',
    showButtons: ['next'],
    /*onDestroyStarted: () => {
      // Guardar cookie al cerrar o terminar
      const exp = new Date();
      exp.setFullYear(exp.getFullYear() + 1);
      document.cookie = `${COOKIE_KEY}=true; expires=${exp.toUTCString()}; path=/`;
      driverObj.destroy();
    },*/
    steps
  });

  driverObj.drive();
}

function cargarYEjecutar() {
  if (typeof window.driver !== 'undefined') {
    initDriver();
    return;
  }

  const s = document.createElement('script');
  s.src = 'https://cdn.jsdelivr.net/npm/driver.js@latest/dist/driver.js.iife.js';
  s.onload = () => {
    console.log('driver.js cargado');
    initDriver();
  };
  s.onerror = () => console.error('Fallo al cargar driver.js');
  document.head.appendChild(s);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', cargarYEjecutar);
} else {
  cargarYEjecutar();
}