import Projects from '@/components/projects/Projects'
import Loading from '@/components/layout/Loading'
import { mount } from 'avoriaz'

describe('Projects.vue', () => {
  const wrapper = mount(Projects)

  it('should have default data', () => {
    const defaultData = wrapper.data()
    expect(defaultData.isLoaded).to.equal(false)
    expect(defaultData.selectedYear).to.equal(new Date().getFullYear())
    expect(defaultData.selectedStatus).to.equal(1)
    expect(defaultData.searchText).to.equal('')
  })

  it('should render loading spinner', () => {
    const loading = wrapper.find(Loading)[0]
    expect(loading.is(Loading)).to.equal(true)
  })
})
