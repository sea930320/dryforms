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
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Formorder.vue'], resolve)
    }
  },
  {
    path: '/standards/form_id/:form_id',
    name: 'Standards Form',
    meta: {
      roles: ['customer'],
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Main.vue'], resolve)
    }
  },
  {
    path: '/standards/scope',
    name: 'Project Scope',
    props: {title: 'Scope'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Scope.vue'], resolve)
    }
  },
  {
    path: '/standards/authorization',
    name: 'Work Authorization',
    props: {title: 'Authorization'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Authorization.vue'], resolve)
    }
  },
  {
    path: '/standards/antimicrobial',
    name: 'Anti-Microbial',
    props: {title: 'antimicrobial'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Antimicrobial.vue'], resolve)
    }
  },
  {
    path: '/standards/responsibility',
    name: 'Customer Responsibility',
    props: {title: 'Responsibility'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Responsibility.vue'], resolve)
    }
  },
  {
    path: '/standards/liability',
    name: 'Release from Liability',
    props: {title: 'Liability'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Liability.vue'], resolve)
    }
  },
  {
    path: '/standards/stoppage',
    name: 'Work Stoppage',
    props: {title: 'Stoppage'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Stoppage.vue'], resolve)
    }
  },
  {
    path: '/standards/certificate',
    name: 'Certificate of Completion',
    props: {title: 'Certificate'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Certificate.vue'], resolve)
    }
  },
  {
    path: '/standards/areas',
    name: 'Affected Areas',
    props: {title: 'Areas'},
    meta: {
      title: 'Standard Areas Management',
      roles: ['customer'],
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
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Crews.vue'], resolve)
    }
  },
  {
    path: '/standards/structures',
    name: 'Structures',
    props: {title: 'Structures'},
    meta: {
      title: 'Standard  Moisture Map Structures Dropdown Management',
      roles: ['customer'],
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Structures.vue'], resolve)
    }
  },
  {
    path: '/standards/materials',
    name: 'Materials',
    props: {title: 'Materials'},
    meta: {
      title: 'Standard  Moisture Map Materials Dropdown Management',
      roles: ['customer'],
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Materials.vue'], resolve)
    }
  },
  {
    path: '/standards/calendar',
    name: 'Calendar',
    props: {title: 'Calendar'},
    meta: {
      title: 'Calendar',
      roles: ['customer'],
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/right-link/Calendar.vue'], resolve)
    }
  }
]

export default routes
