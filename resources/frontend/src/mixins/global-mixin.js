export default {
  data: function() {
    return {
      get template_size() {
        return 'sm'
      },
      get pageSizeOption() {
        return [
          {
            text: 5,
            value: 5
          },
          {
            text: 10,
            value: 10
          },
          {
            text: 15,
            value: 15
          },
          {
            text: 20,
            value: 20
          }
        ]
      },
      get defLen() {
        return 50
      }
    }
  }
}
