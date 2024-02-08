import AppForm from '../app-components/Form/AppForm';

Vue.component('invoice-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                customer_id: this.data.customer_id || '',
                invoice_series_id: this.data.invoice_series_id || '',
                invoiceItems: this.data.items || [],
                description: this.data.description || '',
                issue_date: this.data.issue_date || '',
                payment_received_date: this.data.payment_received_date || ''
            }
        }
    },
    methods: {
        addInvoiceItem() {
            console.log(this.form);
            this.form.invoiceItems.push({
                name: '',
                unit_price: 0,
                unit: '',
                vat_rate_id: '',
                quantity: 1,
            });
        },
        removeInvoiceItem(index) {
            this.form.invoiceItems.splice(index, 1);
        }
    }
});
