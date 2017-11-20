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
    },
    {
        path: '/equipment/remove',
        name: 'Remove Equipment'
    },
    {
        path: '/equipment/set',
        name: 'Set Equipment'
    },
    {
        path: '/equipment/pick-up',
        name: 'Pick Up Equipment'
    },
    {
        path: '/equipment/ooc',
        name: 'O.O.C. Equipment'
    },
    {
        path: '/equipment/ooc/return',
        name: 'Return O.O.C. Equipment'
    },
    {
        path: '/equipment/loan',
        name: 'Loan Equipment'
    },
    {
        path: '/equipment/loan/return',
        name: 'Return Loan Equipment'
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
    }
]

export default routes
