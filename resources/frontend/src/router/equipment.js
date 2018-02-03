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
            rightLinks: rightLinks,
            requiresAuth: true
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
            rightLinks: rightLinks,
            requiresAuth: true
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
            rightLinks: rightLinks,
            requiresAuth: true
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
            rightLinks: rightLinks,
            requiresAuth: true
        },
        component: resolve => {
            require(['../components/equipment/Add.vue'], resolve)
        }
    },
    {
        path: '/equipment/remove',
        name: 'Remove',
        props: {title: 'Remove'},
        meta: {
            title: 'Remove Equipment from Inventory',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/equipment/modals/Remove.vue'], resolve)
        }
    },
    {
        path: '/equipment/set',
        name: 'Set',
        props: {title: 'Set'},
        meta: {
            title: 'Set Equipment',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/equipment/modals/Set.vue'], resolve)
        }
    },
    {
        path: '/equipment/pick-up',
        name: 'Pickup',
        props: {title: 'Pickup'},
        meta: {
            title: 'Pick Up Equipment',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/equipment/modals/Pickup.vue'], resolve)
        }
    },
    {
        path: '/equipment/loan',
        name: 'Loan',
        props: {title: 'Loan'},
        meta: {
            title: 'Loan Equipment',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/equipment/modals/Loan.vue'], resolve)
        }
    },
    {
        path: '/equipment/loan/return',
        name: 'LoanRerturn',
        props: {title: 'LoanRerturn'},
        meta: {
            title: 'Return Loan Equipment',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/equipment/modals/Loanreturn.vue'], resolve)
        }
    }
]

export default routes
