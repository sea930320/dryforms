const leftLinks = []

const rightLinks = []

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
    }
]

export default routes
