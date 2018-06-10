const leftLinks = []

const rightLinks = [
  {
    path: 'support',
    name: 'Suggestion/Support',
    icon: require('../assets/icon-support.png')
  },
  {
    path: '/standards/calendar',
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
  // {
  //   methodCall: {
  //     section: 'forms',
  //     name: 'save'
  //   },
  //   name: 'Save',
  //   icon: require('../assets/icon-save.png')
  // },
  {
    form_id: 12,
    name: 'Affected Areas',
    icon: '',
    mt: true
  },
  {
    form_id: 13,
    name: 'Add Days',
    icon: '',
    mt: true
  },
  {
    form_id: 14,
    name: 'Equipment Manager',
    icon: '',
    mt: true
  }
]

const routes = (configRoute) => [
  {
    path: '/forms/:project_id/select',
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
    path: '/print/:project_id/select',
    name: 'Print',
    props: {title: 'Print'},
    meta: {
      title: 'Print',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/print/Print.vue'], resolve)
    }
  },
  {
    path: '/email/:project_id/select',
    name: 'Email',
    props: {title: 'Email'},
    meta: {
      title: 'Email',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/email/Email.vue'], resolve)
    }
  },
  {
    path: '/forms/:project_id/callreport/:form_id',
    name: 'Form Call Report',
    props: {title: 'Call Report'},
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
    path: '/forms/:project_id/scope/:form_id',
    name: 'Form Project Scope',
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
    path: '/forms/:project_id/dailylog/:form_id',
    name: 'Form Daily Log',
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
    path: '/forms/:project_id/authorization/:form_id',
    name: 'Form Work Authorization',
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
    path: '/forms/:project_id/antimicrobial/:form_id',
    name: 'Form Anti-Microbial',
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
    path: '/forms/:project_id/responsibility/:form_id',
    name: 'Form Customer Responsibility',
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
    path: '/forms/:project_id/moisturemap/:form_id',
    name: 'Form Moisture Map',
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
    path: '/forms/:project_id/psyreport/:form_id',
    name: 'Form Psychometric Report',
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
    path: '/forms/:project_id/liability/:form_id',
    name: 'Form Release from Liability',
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
    path: '/forms/:project_id/stoppage/:form_id',
    name: 'Form Work Stoppage',
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
    path: '/forms/:project_id/certificate/:form_id',
    name: 'Form Certificate of Completion',
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
    path: '/forms/:project_id/areas/:form_id',
    name: 'Form Affected Areas',
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
    path: '/forms/:project_id/customs/:form_id',
    name: 'Custom Form',
    props: {title: 'Custom'},
    meta: {
      title: 'Custom Form',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Custom.vue'], resolve)
    }
  },
  {
    path: '/forms/:project_id/days/:form_id/:prev_id',
    name: 'Form Add Days',
    props: {title: 'Days'},
    meta: {
      title: 'Add Days',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/Days.vue'], resolve)
    }
  },
  {
    path: '/forms/:project_id/equipment_manager/:form_id',
    name: 'Form Equipment Manager',
    props: {title: 'Days'},
    meta: {
      title: 'Add Days',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/forms/EquipmentManager.vue'], resolve)
    }
  }
]

export default routes
