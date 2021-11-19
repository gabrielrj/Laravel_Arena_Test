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
                                Name
                            </th>

                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Value
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
                        <tr v-for="(preference, preference_i) in preferences" :key="preference_i">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ preference.name }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ preference.value }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ preference.created_at }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link v-if="hasPermission(this.$page.props.auth.permissions, $Permissions.EDITPERMISSION)"
                                      title="edit"
                                      :href="route('preferences.edit', preference.id)"
                                      class="cursor-pointer text-gray-600 hover:text-gray-900"><i class="fas fa-edit"></i></Link>
                                &nbsp;
                                <a v-if="hasPermission(this.$page.props.auth.permissions, $Permissions.DELETEPERMISSION)"
                                   title="delete"
                                   @click="deletePreference(preference)"
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
    name: "PreferenceList",
    components: {
        Link
    },
    props: {
        preferences: Array
    },
    inject: ['index'],
    methods: {
        deletePreference(preference) {
            this.index.deletePreference(preference)
        },
        changeStatus(preference){
            this.index.changeStatus(preference)
        }
    },
};
</script>
<style scoped></style>
