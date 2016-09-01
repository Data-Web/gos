import Vue from 'vue'
import VueResource from 'vue-resource'
import VueValidator from 'vue-validator'
import UserService from '../services/user'

Vue.use(VueResource)
Vue.use(VueValidator)

var token = $('meta[name="csrf-token"]').attr('content');

new Vue({
    el: '#profile',

    data: function () {
        return {
            userProfile: {
                _token: '',
                id: '',
                fullname: '',
                phone: '',
                address: '',
                image: '',
                gender: '',
                birthday: ''
            },

            errors: {},
            isError: false,
            isErrorServer: false
        }
    },

    created: function () {
        UserService.setRouter(window.laroute);
        UserService.setHttp(this.$http);
    },

    methods: {
        updateProfile: function (params, id) {
            var self = this;
            UserService.update(params, id).then((response) => {
                toastr.success(response.message);

                if (response.code === 200) {
                    self.reload();
                }
            }, (response) => {
                if (response.errors) {
                    self.errors = response.messages;
                    self.isErrorServer = response.errors;
                }
            });
        },

        validate: function() {
            var self = this;

            this.$validate(true, function () {
                if (self.$validation.invalid) {
                    self.isError = true;
                } else {
                    self.userProfile._token = token;
                    self.updateProfile(self.userProfile, self.userProfile.id);
                }
            });
        },

        reload: function() {
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        }
    }
});
