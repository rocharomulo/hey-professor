import './bootstrap';

import Alpine from 'alpinejs';

import 'flowbite';

window.Alpine = Alpine;

Alpine.start();

// Define o modo escuro como padrão ao carregar a página
document.documentElement.classList.add('dark');
