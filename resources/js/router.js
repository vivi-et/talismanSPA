import Vue from 'vue';
import Router from 'vue-router';

//tutorial routes
import firstpage from './components/pages/myFirstVuePage';
import secondpage from './components/pages/mySecondVuePage';
import hooks from './components/pages/basic/hooks';
import methods from './components/pages/basic/methods';

//project routes
import home from './components/pages/home';
import tags from './components/pages/tags'

Vue.use(Router);

const routes = [
    // projects routes...
    {
        path: '/',
        component: home,

    },

    {
        path: '/tags',
        component: tags,
    },
























    //basic tutorial routes...
    {
        path: '/myfirstpage',
        component: firstpage,

    },

    {
        path: '/mysecondpage',
        component: secondpage
    },

    //vue hooks

    {
        path: '/hooks',
        component: hooks
    },

    //more basics
    {
        path: '/methods',
        component: methods
    },


];

export default new Router({
    mode: 'history',
    routes
})