import AppForm from '../app-components/Form/AppForm';

Vue.component('customer-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                is_company: true,
            }
        }
    },
    watch: {
        'form.is_company': function (newValue) {
            this.form.is_company = (newValue === 'true');
        }
    },

});