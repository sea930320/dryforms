const leftLinks = [
    {
        path: '/settings/account',
        name: 'Account'
    },
    {
        path: '/settings/company',
        name: 'Comany'
    },
    {
        path: '/settings/users',
        name: 'Users'
    },
    {
        path: '/settings/invoices',
        name: 'Invoices'
    }
]

const rightLinks = []

const routes = (configRoute) => [
    {
        path: '/settings/account',
        name: 'Account',
        props: {title: 'Account'},
        meta: {
            title: 'Manage Your Account',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/settings/Account.vue'], resolve)
        }
    },
    {
        path: '/settings/company',
        name: 'Company',
        props: {title: 'Company'},
        meta: {
            title: 'Manage Your Company Profile',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/settings/Company.vue'], resolve)
        }
    }
]

export default routes
