<template>
    <section class="rounded-xl">
        <div class="mx-auto w-full rounded">
            <div class="relative overflow-hidden shadow-xl shadow-gray-500 border-blue-900 bg-white rounded">
                <div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                    <div class="flex items-center flex-1 space-x-4">
                        <h5>
                            <span class="text-blue-800">{{ label }}: </span>
                            <span class=""> {{ itemsTotal }}</span>
                        </h5>
                    </div>
                    <div class="flex flex-col flex-shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">
                        <template v-if="add">
                            <a :href="addRoute">
                                <SecondaryButton>
                                    <PlusIcon /> Add new {{ label }}
                                </SecondaryButton>
                            </a>
                        </template>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full table-fixed text-sm text-left">
                        <thead class="text-xs uppercase bg-blue-400">
                           <tr>
                            <template :key="index" v-for="(column, index) in columns">
                                <th role="button" column-width="150px" @click="updateParam(column)"
                                     class="px-4 py-3 whitespace-nowrap w-[150px]">{{ column.label }}</th>
                            </template>
                            <template v-if="action">
                                <th  class="px-4 py-3 whitespace-nowrap w-[150px]">Actions</th>
                            </template>
                        </tr>

                        </thead>
                        <tbody>
                            <tr class="border-gray-100 hover:bg-gray-300" v-for="(item, index) in records" :key="index">
                                 <template v-for="(column, columnIndex) in columns" :key="columnIndex">
                                    <td
                                        class="px-4 py-2 w-[150px] overflow-x-auto border-b font-medium text-gray-900 whitespace-nowrap">
                                        <div class="flex items-center">

                                            <slot :name="column.key" :item="item">

                                                <div>{{ getValue(item, column) }}</div>
                                            </slot>
                                        </div>
                                    </td>
                                </template>
                                <template v-if="action">
                                    <td class="px-4 w-[150px] py-2 font-medium text-blue-900 whitespace-nowrap">
                                        <!-- Action buttons here -->
                                    </td>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="md:flex md:justify-between items-center p-4">
                    <!-- Limit Selector and Pagination -->
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PlusIcon from '@/Components/Icons/Plus.vue';
import Pen from '@/Components/Icons/Pen.vue';
import Trash from '@/Components/Icons/Trash.vue';
import Eye from '@/Components/Icons/Eye.vue';
import { Link } from '@inertiajs/vue3';
import moment from 'moment-timezone';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';



export default {

    name: "DataTable",
    props: {
        label: String,
        action: Boolean,
        columns: Array,
        records: Array,
        itemsTotal: Number,
        add: Boolean,
        addRoute: String,
        editRoute: String,
        showRoute: String,
        deleteRoute: String,
        paginate: Object,
    },
    components: {
        SecondaryButton,
        PrimaryButton,
        DangerButton,
        PlusIcon,
        Pen,
        Trash,
        Eye,
        Link,
    },
    data() {
        return {
            limit: 10,
            sortField: this.sortBy || 'id',
            sortDirection: 'desc',
            dataCount:0,
        };
    },
    methods: {
        getValue(item, column) {
            // By default, render the item value as a string

                return item[column.key];

        },
        updateParam(column) {
            if (this.sortField === column.key) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortField = column.key;
                this.sortDirection = 'asc';
            }
            this.$emit('fetchItems');
        },
        async deleteRecord(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                await axios.delete(this.deleteRoute + '/' + id)
                    .then(response => {
                        toast.success(response.data.message);
                        this.$emit('fetchItems');
                    })
                    .catch(error => {
                        this.$emit('fetchItems');
                    });
            }
        },
        getRelationData(item, column) {
            if (column.path && typeof column.path === 'string' && column.path.trim() !== '') {
                return column.path.split('.').reduce((o, k) => (o || {})[k], item);
            }
            return null;
        },
        formatDate(dateStr, format = null) {
            return moment.utc(dateStr).tz('America/Los_Angeles').format('MM/DD hh:mm A');
        }
    }
}
</script>
