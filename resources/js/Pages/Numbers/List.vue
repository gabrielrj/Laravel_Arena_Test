<template>
    <Head title="Number" />

    <BreezeAuthenticated>

        <template #header>
            <h1 class="text-3xl font-bold text-gray-900">
                Numbers
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <BreezeValidationErrors class="mb-4" />

                        <!--Alert class="mb-4" :status="$page.props.flash.message" :msg="msg"></Alert-->
                        <section v-if="customerList.length === 0" class="mb-4">
                            <div class="block text-sm text-left text-white bg-gray-500 h-12 flex items-center p-4 rounded-md"
                                 role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     class="w-6 h-6 mx-2 stroke-current">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                                There are no registered customers, first register a customer and then register the phone numbers.
                            </div>
                        </section>

                        <section v-else>
                            <div class="mb-4">
                                <BreezeLabel for="customer" value="Select the customer" />
                                <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                        name="customer" id="customer"
                                        v-model="customerSelectedId">
                                    <option value="" disabled>Select status</option>
                                    <option v-for="(customer, customer_i) in customers"
                                            :key="customer_i"
                                            :value="customer.id"
                                            :title="customer.name">{{ customer.name }}</option>
                                </select>
                            </div>

                            <section v-if="customerSelectedId" class="mb-4">
                                <Link v-if="hasPermission(this.$page.props.auth.permissions, $Permissions.CREATEPERMISSION)"
                                      :href="route('numbers.create', customerSelectedId)"
                                      class="float-right bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-sm px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                      type="button">
                                    <i class="fas fa-plus"></i> New Number
                                </Link>

                                <br>
                                <br>

                                <div v-if="numbers.length === 0"
                                     class="block text-sm text-left text-white bg-gray-500 h-12 flex items-center p-4 rounded-md"
                                     role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         class="w-6 h-6 mx-2 stroke-current">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                    No registered numbers were found
                                </div>

                                <NumberList v-else :numbers="numbers" :customer="customerSelected"></NumberList>
                            </section>

                            <section v-else class="mb-4">
                                <div class="block text-sm text-left text-white bg-gray-500 h-12 flex items-center p-4 rounded-md"
                                     role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         class="w-6 h-6 mx-2 stroke-current">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                    Select the customer to view the registered numbers.
                                </div>
                            </section>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticated>
</template>

<script>
import BreezeLabel from '@/Components/Label.vue';
import BreezeAuthenticated from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import NumberList from "@/Components/Numbers/NumberList";
import {Link} from "@inertiajs/inertia-vue3";
import Swal from 'sweetalert2'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import Alert from "@/Components/Alert";


export default {
    components: {
        BreezeAuthenticated,
        Head,
        NumberList,
        Link,
        BreezeValidationErrors,
        Alert,
        BreezeLabel
    },
    provide() {
        return {
            index: this
        }
    },
    props: {
        customers: Array,
    },
    data() {
        return {
            numbers: [],
            customerList: this.customers,
            customerSelectedId: null,
            customerSelected: null,
        }
    },
    watch: {
        customers: {
            handler(){
                this.customerList = this.customers
            },
            deep: true,
        },
        customerSelectedId() {
            this.updateNumberList()
        }
    },
    methods: {

        deleteNumber(number){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(`/numbers/${number.id}`, {
                        //preserveState: true,
                        onSuccess: () => {
                            Swal.fire('Success', 'Successfully deleted number.', 'success')

                            this.updateNumberList()
                        }
                    })
                }
            })

        },

        async changeStatus(number){
            let arrStatus = ['active', 'inactive', 'cancelled']

            let indexOfStatusNumberInArrStatus = _.indexOf(arrStatus, number.status)

            arrStatus.splice(indexOfStatusNumberInArrStatus, 1)

            let options = {}

            _.forEach(arrStatus, (status) => {
                options[status] = status
            })

            const { value: statusSelected } = await Swal.fire({
                title: 'Select new status of the number',
                input: 'select',
                inputOptions: options,
                inputPlaceholder: 'Select a status',
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value !== '') {
                            resolve()
                        } else {
                            resolve('Select the status of the number. :)')
                        }
                    })
                }
            })

            if (statusSelected) {
                this.$inertia.put(`/numbers/change/status/${number.id}`, {'status' : statusSelected}, {
                    only: ['customers'],
                    onSuccess: () => {
                        Swal.fire('Success', 'Successfully updated number.', 'success')

                        this.updateNumberList()
                    }
                })
            }
        },

        updateNumberList(){
            this.customerSelected = null
            this.numbers.splice(0, this.numbers.length)

            if(this.customerSelectedId != null) {
                this.customerSelected = _.find(this.customers, (customer) => {
                    return customer.id == this.customerSelectedId
                })

                this.numbers = this.customerSelected.numbers
            }
        }
    },
}
</script>
