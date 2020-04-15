Vue.component('wpcfto_file', {
    props: ['field_label', 'field_name', 'field_id', 'field_value', 'field_data'],
    data: function () {
        return {
            data: '',
            error: '',
            value: {
                name: '',
                url: '',
                path: '',
            },
            input_value: '',
            uploading: false
        }
    },
    template: `
        <div class="wpcfto_generic_field wpcfto_generic_field__file">
        
       
            <label v-html="field_label"></label>
            
            <label class="file-select" v-if="!value.path">
            
                <div class="select-button">
                    <span v-html="field_data.load_labels.label" v-if="!uploading"></span>
                    <span v-html="field_data.load_labels.loading" v-else></span>
                </div>
                
                <input type="file" :accept="field_data['accept'].join(',')" @change="handleFileChange" />
            </label>
            
            <div class="field_label_error" v-if="error" v-html="error"></div>
          
            <div class="field_label__file" v-if="value.url">
                <a v-bind:href="value.url" target="_blank">
                    <i class="fa fa-file"></i>
                    {{field_data.load_labels.loaded}}
                </a>
                
                <a href="#" @click.prevent="deleteFile()">
                    {{field_data.load_labels.delete}}
                </a>
            </div>  
          
            
            <input type="hidden"
                v-bind:name="field_name"
                v-bind:placeholder="field_label"
                v-bind:id="field_id"
                v-model="input_value"
            />
            
        </div>
    `,
    mounted: function () {
        if(typeof this.field_value !== 'undefined') {
            this.value = JSON.parse(this.field_value);
        }

        this.data = this.field_data;
    },
    methods: {
        handleFileChange(e) {
            var _this = this;
            if (e.target.files.length) {
                var file = e.target.files[0];
                _this.uploading = true;
                _this.error = '';

                var formData = new FormData();
                formData.append('file', file);
                formData.append('field', this.field_name);

                var url = stm_wpcfto_ajaxurl + '?action=wpcfto_upload_file&nonce=' + stm_wpcfto_nonces['wpcfto_upload_file'];

                _this.$http.post(url, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function (r) {
                    r = r.body;
                    if (r.error) {
                        _this.$set(_this, 'error', r.error);
                    } else {
                        _this.$set(_this, 'value', r);
                        _this.uploading = false;
                    }
                })

            }
        },
        deleteFile() {
            this.$set(this, 'value', {
                path: '',
                url: ''
            })
        }
    },
    watch: {
        value: function (value) {
            var stringified = JSON.stringify(value);
            if(value.path === '' && value.url === '') stringified = '';
            this['input_value'] = stringified;
            this.$emit('wpcfto-get-value', stringified);
        }
    }
});