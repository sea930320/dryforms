const leftLinks = [
  {
    path: '/forms/select',
    name: 'Forms',
    icon: 'fa-files-o',
    mb: true
  },
  {
    path: '/forms/callreport',
    name: 'Call Report',
    icon: 'phone'
  },
  {
    path: '/forms/scope',
    name: 'Project Scope',
    icon: 'fa-newspaper-o'
  },
  {
    path: '/forms/dailylog',
    name: 'Daily Log',
    icon: 'chat'
  },
  {
    path: '/forms/authorization',
    name: 'Work Authorization',
    icon: 'fa-pencil'
  },
  {
    path: '/forms/antimicrobial',
    name: 'Anti-Microbial',
    icon: 'fa-certificate'
  },
  {
    path: '/forms/responsibility',
    name: 'Customer Responsibility',
    icon: 'fa-hand-grab-o'
  },
  {
    path: '/forms/moisturemap',
    name: 'Moisture Map',
    icon: 'fa-tint'
  },
  {
    path: '/forms/psyreport',
    name: 'Psychometric Report',
    icon: 'fa-flag'
  },
  {
    path: '/forms/liability',
    name: 'Release from Liability',
    icon: 'fa-chain-broken'
  },
  {
    path: '/forms/stoppage',
    name: 'Work Stoppage',
    icon: 'fa-hand-paper-o'
  },
  {
    path: '/forms/certificate',
    name: 'Certificate of Completion',
    icon: 'fa-trophy'
  }
]

const rightLinks = [
  {
    path: 'support',
    name: 'Suggestion/Support',
    icon: 'fa-ticket'
  },
  {
    path: 'calendar',
    name: 'Calendar',
    icon: 'fa-calendar-o'
  },
  {
    path: 'preview',
    name: 'Preview',
    icon: 'fa-eye'
  },
  {
    path: 'email',
    name: 'Email',
    icon: 'fa-envelope-o'
  },
  {
    path: 'print',
    name: 'Print',
    icon: 'fa-print'
  },
  {
    path: 'save',
    name: 'Save',
    icon: 'fa-floppy-o'
  },
  {
    path: '/forms/areas',
    name: 'Affected Areas',
    icon: 'fa-bullseye',
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
  }
]

export default routes
