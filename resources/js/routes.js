let routes=[
{
  path: '/',
  name: '',
  component: require('./components/ExampleComponent.vue').default
},
{
  path: '/back/inventory/table',
  component: require('./components/back/inventory/table.vue').default
},
{
  path: '/back/inventory/table/:group/:type',
  component: require('./components/back/inventory/table.vue').default
},
{
  path: '/back/inventory/received',
  component: require('./components/back/inventory/received.vue').default
},
{
  path: '/back/inventory/received/:id',
  component: require('./components/back/inventory/received.vue').default
},/*
{
  path: '/back/inventory/received/:id',
  component: require('./components/back/inventory/received.vue').default
}

{
  path: '/home',
  name: 'dashboard',
  component: require('./components/page/Home.vue').default
},
{
  path: '/profile/:id',
  name: 'profile',
  component: require('./components/page/Profile.vue').default
},
{
  path: '/profile',
  name: 'profile',
  component: require('./components/page/Profile.vue').default
},
{
  path: '/login',
  name: 'login',
  component: require('./components/page/Signin.vue').default
}*//*
{
  path: '/biodata/:id',
  component: require('./components/page/Biodata.vue').default
},
{
  path: '/biodata',
  component: require('./components/page/Biodata.vue').default
},
{
  path: '/about',
  name: 'about',
  component: require('./components/page/About.vue').default
}*/];

/*export default new VueRouter({
        routes,
        mode: 'history'
})*/
export default routes