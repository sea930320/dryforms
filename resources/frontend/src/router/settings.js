const leftLinks = [
    {
        path: '/settings/account',
        name: 'Account'
    },
    {
        path: '/settings/company',
        name: 'Company'
    },
    {
        path: '/settings/users',
        name: 'Users'
    },
    {
        path: '/settings/teams',
        name: 'Teams'
    },
    {
        path: '/settings/invoices',
        name: 'Invoices'
    }
]

const rightLinks = [
    {
      path: '/settings/support/create',
      name: 'Suggestions/Support',
      icon: require('../assets/icon-support.png')
    },
    {
      path: '/settings/calendar',
      name: 'Calendar',
      icon: require('../assets/icon-calendar.png')
    }
]

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
    },
    {
        path: '/settings/credit-card',
        name: 'CreditCard',
        props: {title: 'CreditCard'},
        meta: {
            title: 'Update Your Credit Card',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/settings/CreditCard.vue'], resolve)
        }
    },
    {
        path: '/settings/users',
        name: 'Users',
        props: {title: 'Users'},
        meta: {
            title: 'Manage Your Users',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/settings/Users.vue'], resolve)
        }
    },
    {
        path: '/settings/teams',
        name: 'Teams',
        props: {title: 'Teams'},
        meta: {
            title: 'Manage Your Teams',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/settings/Teams.vue'], resolve)
        }
    },
    {
        path: '/settings/calendar',
        name: 'Calendar',
        props: {title: 'Calendar'},
        meta: {
          title: 'Calendar',
          roles: ['customer'],
          leftLinks: leftLinks,
          rightLinks: rightLinks
        },
        component: resolve => {
          require(['../components/standards/right-link/Calendar.vue'], resolve)
        }
    },
    {
        path: '/settings/support/list',
        name: 'UserTickets',
        props: {title: 'My Tickets'},
        meta: {
          title: 'My Tickets',
          roles: ['customer'],
          leftLinks: leftLinks,
          rightLinks: rightLinks
        },
        component: resolve => {
          require(['../components/ticket/UserTickets.vue'], resolve)
        }
    },
    {
        path: '/settings/support/create',
        name: 'CreateTicket',
        props: {title: 'Open New Ticket'},
        meta: {
          title: 'Open New Ticket',
          roles: ['customer'],
          leftLinks: leftLinks,
          rightLinks: rightLinks
        },
        component: resolve => {
          require(['../components/ticket/Create.vue'], resolve)
        }
    }
]

export default routes
