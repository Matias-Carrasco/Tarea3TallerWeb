import './bootstrap';

import react from 'react';
import { createRoot } from 'react-dom/client'

import App from './components/App';


if (document.getElementById('app')){
    const container = document.getElementById('app');
    const root = createRoot(container);
    root.render(<App />);
}