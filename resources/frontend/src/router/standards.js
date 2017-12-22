const leftLinks = [
  {
    path: '/standards/formorder',
    name: 'Forms Order',
    icon: require('../assets/icon-forms.png'),
    mb: true
  },
  {
    path: '/standards/scope',
    name: 'Project Scope',
    icon: require('../assets/icon-scope.png')
  },
  {
    path: '/standards/authorization',
    name: 'Work Authorization',
    icon: require('../assets/icon-workauth.png')
  },
  {
    path: '/standards/antimicrobial',
    name: 'Anti-Microbial',
    icon: require('../assets/icon-antimicrobial.png')
  },
  {
    path: '/standards/responsibility',
    name: 'Customer Responsibility',
    icon: require('../assets/icon-customer.png')
  },
  {
    path: '/standards/liability',
    name: 'Release from Liability',
    icon: require('../assets/icon-release.png')
  },
  {
    path: '/standards/stoppage',
    name: 'Work Stoppage',
    icon: require('../assets/icon-workstop.png')
  },
  {
    path: '/standards/certificate',
    name: 'Certificate of Completion',
    icon: require('../assets/icon-complete.png')
  },
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
    path: '/standards/structures',
    name: 'Structures',
    icon: require('../assets/icon-structure.png')
  },
  {
    path: '/standards/materials',
    name: 'Materials',
    icon: require('../assets/icon-moisture.png')
  }
]

const rightLinks = [
  {
    path: 'support',
    name: 'Suggestions/Support',
    icon: require('../assets/icon-support.png')
  },
  {
    path: 'calendar',
    name: 'Calendar',
    icon: require('../assets/icon-calendar.png')
  },
  {
    path: '/standards/createform',
    name: 'Create Form',
    icon: '',
    mt: true
  }
]

const routes = (configRoute) => [
  {
    path: '/standards',
    redirect: '/standards/formorder'
  },
  {
    path: '/standards/formorder',
    name: 'Formorder',
    props: {title: 'Formorder'},
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
    name: 'Scope',
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
    path: '/standards/authorization',
    name: 'Authorization',
    props: {title: 'Authorization'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Authorization.vue'], resolve)
    }
  },
  {
    path: '/standards/antimicrobial',
    name: 'Antimicrobial',
    props: {title: 'antimicrobial'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Antimicrobial.vue'], resolve)
    }
  },
  {
    path: '/standards/responsibility',
    name: 'Responsibility',
    props: {title: 'Responsibility'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Responsibility.vue'], resolve)
    }
  },
  {
    path: '/standards/liability',
    name: 'Liability',
    props: {title: 'Liability'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Liability.vue'], resolve)
    }
  },
  {
    path: '/standards/stoppage',
    name: 'Stoppage',
    props: {title: 'Stoppage'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Stoppage.vue'], resolve)
    }
  },
  {
    path: '/standards/certificate',
    name: 'Certificate',
    props: {title: 'Certificate'},
    meta: {
      title: 'Standards',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Certificate.vue'], resolve)
    }
  },
  {
    path: '/standards/areas',
    name: 'Areas',
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
    path: '/standards/structures',
    name: 'Structures',
    props: {title: 'Structures'},
    meta: {
      title: 'Standard  Moisture Map Structures Dropdown Management',
      roles: ['customer'],
      leftLinks: leftLinks,
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
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/standards/Materials.vue'], resolve)
    }
  }
]

export default routes
