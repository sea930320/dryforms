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
    methodCall: {
      section: 'standards',
      name: 'save'
    },
    name: 'Save',
    icon: require('../assets/icon-save.png')
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
  }
]

export default routes
