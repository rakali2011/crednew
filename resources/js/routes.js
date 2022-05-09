export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/quickupdates', component: require('./components/quickupdate/Quickupdates.vue').default },
    { path: '/providers', component: require('./components/provider/Providers.vue').default },
    { path: '/documents', component: require('./components/document/Documents.vue').default },
    { path: '/payers', component: require('./components/payer/Payers.vue').default },
    { path: '/activity', component: require('./components/activity/Activity.vue').default },
    { path: '/report/appstatus', component: require('./components/report/Appstatus.vue').default },
    { path: '/report/productivity', component: require('./components/report/Productivity.vue').default },
    { path: '/report/export', component: require('./components/report/Export.vue').default },
    { path: '/products', component: require('./components/product/Products.vue').default },
    { path: '/practices', component: require('./components/practice/Practices.vue').default },
    { path: '/product/tag', component: require('./components/product/Tag.vue').default },
    { path: '/product/category', component: require('./components/product/Category.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
];
