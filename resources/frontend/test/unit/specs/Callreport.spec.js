import Callreport from '@/components/forms/Callreport'
import FormHeader from '@/components/forms/FormHeader'
import Notes from '@/components/forms/Notes'
import { mount } from 'avoriaz'

describe('Callreport.vue', () => {
  const wrapper = mount(Callreport)

  it('should a title that equals props title', () => {
    const title = 'title'
    const wrapper = mount(Callreport, { propsData: { title } })
    const text = wrapper.find('h4')[0].text()
    expect(text).to.equal('title')
  })

  it('should render header section', () => {
    const formheader = wrapper.find(FormHeader)[0]
    expect(formheader.is(FormHeader)).to.equal(true)
  })

  it('should render additional notes section', () => {
    const notes = wrapper.find(Notes)[0]
    expect(notes.is(Notes)).to.equal(true)
  })

  it('should copy job address when checkbox(same as job address) is clicked', done => {
    const data = wrapper.data()
    wrapper.setData({formModel2: {jobAddress: 'address'}})
    // switch the value of checkbox to true
    wrapper.setData({sameJobAddress: true})
    expect(data.sameJobAddress).to.equal(true)
    wrapper.find('#copy_address')[0].trigger('input')
    wrapper.vm.$nextTick(() => {
      expect(data.formModel3.address).to.equal('address')
      done()
    })
  })

  it('should copy owner name when checkbox(same as contact name) is clicked', done => {
    const data = wrapper.data()
    wrapper.setData({formModel1: {contactName: 'contact'}})
    wrapper.setData({formModel3: {ownerName: ''}})
    // switch the value of checkbox to true
    wrapper.setData({sameContactName: true})
    expect(data.sameContactName).to.equal(true)
    wrapper.find('#copy_name')[0].trigger('input')
    wrapper.vm.$nextTick(() => {
      expect(data.formModel3.ownerName).to.equal('contact')
      done()
    })
  })
})
