<template>
    <div class="flex flex-col text-left">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div
                    class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Number
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>

                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Registration date
                            </th>

                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(number, number_i) in listOfNumbers" :key="number_i">
                            <!--td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img
                                            class="h-10 w-10 rounded-full"
                                            src="https://images.unsplash.com/photo-1619914775389-748e5e136c26?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=100&ixid=MnwxfDB8MXxyYW5kb218fHx8fHx8fHwxNjIwMTk4MjAw&ixlib=rb-1.2.1&q=80&utm_campaign=api-credit&utm_medium=referral&utm_source=unsplash_source&w=100"
                                            alt="" />
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Flora Wu
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            flora.wu@example.com
                                        </div>
                                    </div>
                                </div>
                            </td-->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ customer.name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number.number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span title="Click to change number status." @click="changeStatus(number)" class="cursor-pointer flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-red-100 border"
                                    :class="{ 'bg-blue-500 border-blue-700' : number.status === 'active',
                                    'bg-yellow-500 border-yellow-700' : number.status === 'inactive',
                                    'bg-red-500 border-red-700' : number.status === 'cancelled' }">
                                    <span class="text-xs font-normal leading-none max-w-full flex-initial">{{ number.status }}</span>
                                </span>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number.created_at }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link v-if="hasPermission(this.$page.props.auth.permissions, $Permissions.VIEWPERMISSION)"
                                      title="view preferences"
                                      :href="route('preferences.index', number.id)"
                                      class="cursor-pointer text-blue-600 hover:text-blue-900"><i class="fas fa-eye"></i></Link>
                                &nbsp;
                                <Link v-if="hasPermission(this.$page.props.auth.permissions, $Permissions.EDITPERMISSION)"
                                      title="edit"
                                   :href="route('numbers.edit', number.id)"
                                   class="cursor-pointer text-gray-600 hover:text-gray-900"><i class="fas fa-edit"></i></Link>
                                &nbsp;
                                <a v-if="hasPermission(this.$page.props.auth.permissions, $Permissions.EDITPERMISSION)"
                                   title="delete"
                                   @click="deleteNumber(number)"
                                   class="cursor-pointer text-red-600 hover:text-red-900"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "NumberList",
    components: {
        Link
    },
    props: {
        numbers: {
            type: Array,
            default: () => []
        },
        customer: {
            type: Object,
            default: () => {}
        },
    },
    data() {
        return {
            numberList: this.numbers,
            customerOwner: this.customer,
        }
    },
    watch: {
        numbers: {
            handler: function (){
                this.numberList = this.numbers
            },
            deep: true
        },
        customer: {
            handler: function (){
                this.customerOwner = this.customer
            },
            deep: true
        }
    },
    inject: ['index'],
    computed: {
        listOfNumbers() {
            return this.numberList
        }
    },
    methods: {
        deleteNumber(number) {
            this.index.deleteNumber(number)
        },
        changeStatus(number){
            if(!this.hasPermission(this.$page.props.auth.permissions, this.$Permissions.EDITPERMISSION))
                return false

            this.index.changeStatus(number)
        }
    },
};
</script>
<style scoped></style>
