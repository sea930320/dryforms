const leftLinks = [
    {
        path: '/equipment/categories',
        name: 'Categories'
    },
    {
        path: '/equipment/models',
        name: 'Models'
    }
]

const rightLinks = [
    {
        path: '/equipment/add',
        name: 'Add Equipment'
    }
]

const routes = (configRoute) => [
    {
        path: '/equipment',
        name: 'Equipment',
        props: {title: 'Equipment'},
        meta: {
            title: 'Manage Your Inventory',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/equipment/List.vue'], resolve)
        }
    },
    {
        path: '/equipment/detail/cat/:category_id?/mod/:model_id?/stat/:status_id?',
        name: 'Equipment Detail',
        props: {title: 'Equipment Detail'},
        meta: {
            title: 'Detail Information',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/equipment/Detail.vue'], resolve)
        }
    },
    {
        path: '/equipment/categories',
        name: 'Categories',
        props: {title: 'Categories'},
        meta: {
            title: 'Manage Equipment Categories',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/equipment/categories/Categories.vue'], resolve)
        }
    },
    {
        path: '/equipment/models',
        name: 'Models',
        props: {title: 'Models'},
        meta: {
            title: 'Manage Equipment Models',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/equipment/models/Models.vue'], resolve)
        }
    },
    {
        path: '/equipment/add',
        name: 'Add',
        props: {title: 'Add'},
        meta: {
            title: 'Add Equipment to Inventory',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/equipment/Add.vue'], resolve)
        }
    }
]

export default routes
