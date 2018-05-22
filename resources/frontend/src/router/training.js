const leftLinks = []

const rightLinks = [
    {
        path: '/training/support',
        name: 'Suggestions/Support',
        icon: require('../assets/icon-support.png')
    },
    {
        path: '/training/calendar',
        name: 'Calendar',
        icon: require('../assets/icon-calendar.png')
    }
]

const routes = (configRoute) => [
    {
        path: '/training',
        name: 'Training First Page',
        props: { title: 'Training' },
        meta: {
            title: 'Training',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/training/Training.vue'], resolve)
        }
    },
    {
        path: '/training/category_id/:category_id',
        name: 'TrainingCategories',
        meta: {
            title: 'Training',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/training/Main.vue'], resolve)
        }
    },
    {
        path: '/training/calendar',
        name: 'Calendar',
        props: { title: 'Calendar' },
        meta: {
            title: 'Calendar',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/training/right-link/Calendar.vue'], resolve)
        }
    },
    {
        path: '/training/dailylog',
        name: 'Daily Log',
        props: { title: 'Daily Log' },
        meta: {
            title: 'Daily Log',
            roles: ['customer'],
            leftLinks: leftLinks,
            rightLinks: rightLinks
        },
        component: resolve => {
            require(['../components/training/Dailylog.vue'], resolve)
        }
    }
]

export default routes
