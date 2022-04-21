let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let logout = require('./components/auth/logout.vue').default;

const Welcome = () => import('./components/Welcome.vue');
const TaskList = () => import('./components/task/task.vue');
const TaskCreate = () => import('./components/task/add_task.vue');
const TaskEdit = () => import('./components/task/edit_task.vue');

export const routes = [
    { path: '/login', component: login, name:'/' },
    { path: '/register', component: register, name:'register' },
    { path: '/logout', component: logout, name:'logout' },

    {path: '/', component: Welcome, name: 'home',},
    {path: '/tasks', component: TaskList, name: 'taskList'},
    {path: '/tasks/add', component: TaskCreate, name: 'taskCreate'},
    {path: '/tasks/:id/edit', component: TaskEdit, name: 'taskEdit'},

]

