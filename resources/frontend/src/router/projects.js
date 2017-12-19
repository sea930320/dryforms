const leftLinks = [
  {
    path: '/projects/new',
    name: 'New Project',
    icon: require('../assets/icon-forms.png'),
    mb: true
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
  }
]

const routes = (configRoute) => [
  {
    path: '/projects',
    name: 'Projects',
    props: {title: 'Projects'},
    meta: {
      title: 'Projects',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/projects/Projects.vue'], resolve)
    }
  },
  {
    path: '/projects/new',
    name: 'NewProject',
    props: {title: 'NewProject'},
    meta: {
      title: 'Select Forms for this project',
      roles: ['customer'],
      leftLinks: leftLinks,
      rightLinks: rightLinks
    },
    component: resolve => {
      require(['../components/projects/Newproject.vue'], resolve)
    }
  }
]

export default routes
