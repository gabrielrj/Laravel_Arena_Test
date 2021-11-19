import Authorization from "@/Plugins/Authorization";

require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import hasPermission from '@/Plugins/Authorization.js';
import {Permissions} from "@/Plugins/Authorization";


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const myApp = createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route, hasPermission } });

        myApp.config.globalProperties.$Permissions = Permissions;

        myApp.mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });

