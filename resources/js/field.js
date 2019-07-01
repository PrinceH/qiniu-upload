Nova.booting((Vue, router, store) => {
    Vue.component('index-qiniu-upload', require('./components/IndexField'))
    Vue.component('detail-qiniu-upload', require('./components/DetailField'))
    Vue.component('form-qiniu-upload', require('./components/FormField'))
})
