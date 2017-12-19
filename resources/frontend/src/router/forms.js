const leftLinks = [
  {
    path: '/forms/select',
    name: 'Forms',
    icon: require('../assets/icon-forms.png'),
    mb: true
  },
  {
    path: '/forms/callreport',
    name: 'Call Report',
    icon: require('../assets/icon-callreport.png')
  },
  {
    path: '/forms/scope',
    name: 'Project Scope',
    icon: require('../assets/icon-scope.png')
  },
  {
    path: '/forms/dailylog',
    name: 'Daily Log',
    icon: require('../assets/icon-dailylog.png')
  },
  {
    path: '/forms/authorization',
    name: 'Work Authorization',
    icon: require('../assets/icon-workauth.png')
  },
  {
    path: '/forms/antimicrobial',
    name: 'Anti-Microbial',
    icon: require('../assets/icon-antimicrobial.png')
  },
  {
    path: '/forms/responsibility',
    name: 'Customer Responsibility',
    icon: require('../assets/icon-customer.png')
  },
  {
    path: '/forms/moisturemap',
    name: 'Moisture Map',
    icon: require('../assets/icon-moisture.png')
  },
  {
    path: '/forms/psyreport',
    name: 'Psychometric Report',
    icon: require('../assets/icon-psychometric.png')
  },
  {
    path: '/forms/liability',
    name: 'Release from Liability',
    icon: require('../assets/icon-release.png')
  },
  {
    path: '/forms/stoppage',
    name: 'Work Stoppage',
    icon: require('../assets/icon-workstop.png')
  },
  {
    path: '/forms/certificate',
    name: 'Certificate of Completion',
    icon: require('../assets/icon-complete.png')
  }
]

const rightLinks = [
  {
    path: 'support',
    name: 'Suggestion/Support',
    icon: require('../assets/icon-support.png')
  },
  {
    path: 'calendar',
    name: 'Calendar',
    icon: require('../assets/icon-calendar.png')
  },
  {
    path: 'preview',
    name: 'Preview',
    icon: require('../assets/icon-preview.png')
  },
  {
    path: 'email',
    name: 'Email',
    icon: require('../assets/icon-email.png')
  },
  {
    path: 'print',
    name: 'Print',
    icon: require('../assets/icon-print.png')
  },
  {
    path: 'save',
    name: 'Save',
    icon: require('../assets/icon-save.png')
  },
  {
    path: '/forms/areas',
    name: 'Affected Areas',
    icon: '',
    mt: true
  }
]

const routes = (configRoute) => [
  {
    path: '/forms/select',
    name: 'Forms',
    props: {title: 'Forms'},
    meta: {
      title: 'Forms',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Forms.vue'], resolve)
    }
  },
  {
    path: '/forms/callreport',
    name: 'Callreport',
    props: {title: 'Callreport'},
    meta: {
      title: 'Call Report',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Callreport.vue'], resolve)
    }
  },
  {
    path: '/forms/scope',
    name: 'Projectscope',
    props: {title: 'Projectscope'},
    meta: {
      title: 'Project Scope',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Scope.vue'], resolve)
    }
  },
  {
    path: '/forms/dailylog',
    name: 'dailylog',
    props: {title: 'dailylog'},
    meta: {
      title: 'Daily Log',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/DailyLog.vue'], resolve)
    }
  },
  {
    path: '/forms/authorization',
    name: 'authorization',
    props: {title: 'authorization'},
    meta: {
      title: 'Work Authorization',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Authorization.vue'], resolve)
    }
  },
  {
    path: '/forms/antimicrobial',
    name: 'Antimicrobial',
    props: {title: 'antimicrobial'},
    meta: {
      title: 'Anti-microbial Authorization',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Antimicrobial.vue'], resolve)
    }
  },
  {
    path: '/forms/responsibility',
    name: 'Responsibility',
    props: {title: 'Responsibility'},
    meta: {
      title: 'Customer Responsibility',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Responsibility.vue'], resolve)
    }
  },
  {
    path: '/forms/moisturemap',
    name: 'moisturemap',
    props: {title: 'moisturemap'},
    meta: {
      title: 'Moisture Map',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Moisturemap.vue'], resolve)
    }
  },
  {
    path: '/forms/psyreport',
    name: 'psyreport',
    props: {title: 'psyreport'},
    meta: {
      title: 'Psychometric Report',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Psyreport.vue'], resolve)
    }
  },
  {
    path: '/forms/liability',
    name: 'Liability',
    props: {title: 'Liability'},
    meta: {
      title: 'Release from Liability',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Liability.vue'], resolve)
    }
  },
  {
    path: '/forms/stoppage',
    name: 'Stoppage',
    props: {title: 'Stoppage'},
    meta: {
      title: 'Work Stoppage',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Stoppage.vue'], resolve)
    }
  },
  {
    path: '/forms/certificate',
    name: 'Certificate',
    props: {title: 'Certificate'},
    meta: {
      title: 'Certificate of Completion',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Certificate.vue'], resolve)
    }
  },
  {
    path: '/forms/areas',
    name: 'Areas',
    props: {title: 'Areas'},
    meta: {
      title: 'Affected Areas',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Areas.vue'], resolve)
    }
  },
  {
    path: '/forms/email',
    name: 'Email',
    props: {title: 'Email'},
    meta: {
      title: 'Email',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Email.vue'], resolve)
    }
  }
]

export default routes
