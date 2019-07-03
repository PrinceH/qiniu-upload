<template>
    <default-field :field="field">
        <template slot="field">
            <label
                    :for="labelFor"
                    class="form-file-btn btn btn-default btn-primary select-none"
            >
                {{ __('Choose File') }}
            </label>
            <input ref="QFile"
                   :id="idAttr" type="file"
                   class="form-file-input select-none"
                   :class="errorClasses"
                   :placeholder="field.name"
                   :disabled="isReadonly"
                   @change="fileChange"
            />
            <span class="text-gray-50 select-none" v-if="key"> {{ key }} </span>
            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
        </template>
    </default-field>
</template>


<script>
    import { FormField, HandlesValidationErrors } from 'laravel-nova'
    import * as qiniu from 'qiniu-js'
    import NProgress from 'nprogress'
    import 'nprogress/nprogress.css' //这个样式必须引入
    export default {
        mixins: [FormField, HandlesValidationErrors],
        props: ['resourceName', 'resourceId', 'field'],
        data:() => ({
           file: null, token:'',key:null, observer : {
                next(res){
                    NProgress.set(res.total.percent/100);
                },
                error(err){
                    console.log(err)
                },
                complete(res){
                    this.$vue.key = res.key;
                    this.$vue.$toasted.show('上传完成!', { position: "top-center", type: 'success' });
                }
            },subscription:null,observable:null
        }),
        methods: {
            setInitialValue() {
                this.hash = this.field.value || ''
            },
            fill(formData) {
                formData.append(this.field.attribute, this.key || '')
            },
            async upload(){
                axios.get('/qiniu/upload/key').then(response => {
                    this.token = response.data.token;
                    this.file = this.$refs.QFile.files[0];
                    console.log(this.file);
                    this.observable = qiniu.upload(this.file, this.file.name,this.token);
                    this.subscription = this.observable.subscribe(this.observer); // 上传开始
                    this.subscription.observer.$vue = this;
                });
            },
            fileChange(event) {
                this.upload();
            }
        },
        computed: {
            idAttr() {
                return this.labelFor
            },
            labelFor() {
                return `QFile-${this.field.attribute}`
            },
        },
    }
</script>
<style>
    #nprogress .bar {
        height: 4px !important;
    }
</style>
