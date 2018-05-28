const leftLinks = [
  {
      path: '/standards/areas',
      name: 'Affected Areas',
      icon: require('../assets/icon-antimicrobial.png'),
      mt: true
    },
    {
      path: '/standards/crews',
      name: 'Crews / Teams',
      icon: require('../assets/icon-callreport.png')
    },
    {
      path: '/standards/moisture',
      name: 'Moisture Map',
      icon: require('../assets/icon-moisture.png')
    }
]

const rightLinksMain = [
  {
    path: '/standards/support',
    name: 'Suggestions/Support',
    icon: require('../assets/icon-support.png')
  },
  {
    path: '/standards/calendar',
    name: 'Calendar',
    icon: require('../assets/icon-calendar.png')
  },
  {
    path: '/standards/dailylog',
    name: 'Daily Log'
  }
]

const rightLinks = [
  {
    path: '/standards/support',
    name: 'Suggestions/Support',
    icon: require('../assets/icon-support.png')
  },
  {
    path: '/standards/calendar',
    name: 'Calendar',
    icon: require('../assets/icon-calendar.png')
  },
  {
    path: '/standards/dailylog',
    name: 'Daily Log'
  },
  {
    path: '/standards/formbuild',
    name: 'Form Builder'
  }
]

const routes = (configRoute) => [
  {
    path: '/standards',
    redirect: '/standards/formorder'
  },
  {
    path: '/standards/formorder',
    name: 'Forms Order',
    props: {title: 'Forms Order'},
    meta: {
      title: 'Standard Side Menu Forms order Management',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Formorder.vue'], resolve)
    }
  },
  {
    path: '/standards/scope',
    name: 'Project Scope',
    props: {title: 'Scope'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Scope.vue'], resolve)
    }
  },
  {
    path: '/standards/form_id/:form_id',
    name: 'Standards Form',
    meta: {
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinksMain
    },
    component: resolve => {
      require(['../components/standards/Main.vue'], resolve)
    }
  },
  {
    path: '/standards/areas',
    name: 'Affected Areas',
    props: {title: 'Areas'},
    meta: {
      title: 'Standard Areas Management',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Areas.vue'], resolve)
    }
  },
  {
    path: '/standards/crews',
    name: 'Crews',
    props: {title: 'Crews'},
    meta: {
      title: 'Standard Crews/Teams Dropdown Management',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Crews.vue'], resolve)
    }
  },
  {
    path: '/standards/moisture',
    name: 'Moisture Map',
    props: {title: 'Moisture Map'},
    meta: {
      title: 'Standard Moisture Map Dropdown Management',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Moisture.vue'], resolve)
    }
  },
  {
    path: '/standards/calendar',
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
    path: '/standards/dailylog',
    name: 'Daily Log',
    props: {title: 'Daily Log'},
    meta: {
      title: 'Daily Log',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Dailylog.vue'], resolve)
    }
  },
  {
    path: '/standards/formbuild',
    name: 'Form Builder',
    props: {title: 'Form Builder'},
    meta: {
      title: 'Form Builder',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Formbuilder.vue'], resolve)
    }
  }
]

export default routes
