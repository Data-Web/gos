var plugins = {
  bower: [
    {
      in: 'bootstrap/dist',
      out: 'bootstrap'
    },
    {
      in: 'jquery/dist',
      out: 'jquery'
    },
    {
      in: 'components-font-awesome/css',
      out: 'font-awesome/css'
    },
    {
      in: 'components-font-awesome/fonts',
      out: 'font-awesome/fonts'
    },
    {
      in: 'datatables.net/js',
      out: 'datatables/js'
    },
    {
      in: 'datatables.net-bs/css',
      out: 'datatables-bs/css'
    },
    {
      in: 'datatables.net-bs/js',
      out: 'datatables-bs/js'
    },
    {
      in: 'jasny-bootstrap/dist',
      out: 'jasny-bootstrap'
    },
    {
      in: 'summernote/dist',
      out: 'summernote'
    },
    {
      in: 'select2/dist',
      out: 'select2'
    },
    {
      in: 'bootstrap-datepicker/dist',
      out: 'datepicker'
    },
    {
      in: 'bootstrap-switch/dist',
      out: 'bootstrap-switch'
    },
  ],
  vue: [
    {
      name: 'app.js',
      in: '',
      out: ''
    },
    {
      name: 'room.js',
      in: '',
      out: ''
    }
  ]
}
module.exports = plugins;
