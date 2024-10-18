<script setup>
import { Head, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import DataTable from '@/Components/DataTable.vue';

import { ref, watch } from 'vue';
import axios from 'axios'; // Import Axios
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const selectedDate = ref('');
const records = ref(null);
const dataCount = ref(100);
const counts = ref({
    movies:0,
    theaters:0,
    users:0,
    payments:0
});

const dates = ref(
    ['2024-10-16','2024-10-17', '2024-10-18', '2024-11-20']
);
const total_amount_per_movie = ref(null);
const total_amount_per_theater = ref(null);
const total_amount_per_movie_by_theater = ref(null);




const columns = ref([
    { key: 'amount', label: 'Amount' },
    { key: 'quantity', label: 'Quantity' },


    { key: 'movie', label: 'Movie' },
    { key: 'theater', label: 'Theater' },
    { key: 'user', label: 'User' },
]); // Define the selectedDate ref

const formatCurrency = (value) => {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
  }).format(value / 100); // Assuming total_amount is stored as cents, divide by 100
};

 const load = ()=>{
        records.value = null
            dataCount.value = 0;
            counts.value.movies = 0
            counts.value.users = 0
            counts.value.theaters = 0
            total_amount_per_movie.value = null
            total_amount_per_theater.value = null;
            total_amount_per_movie_by_theater.value=null
    }
// Watch for changes on the selectedDate and send POST request to /payments
watch(selectedDate, (newDate) => {
    if (newDate) {

        load()
        // Send a POST request to /payments with the selected date in the payload
        axios.get('/payments?date='+newDate)
        .then(response => {
            let data = response.data;
            records.value = data.payments.data
            dataCount.value = data.payments.total;
            counts.value.movies = data.counts.movies
            counts.value.users = data.counts.users
            counts.value.theaters = data.counts.theaters
            total_amount_per_movie.value = data.total_amount_per_movie
            total_amount_per_theater.value = data.total_amount_per_theater;
            total_amount_per_movie_by_theater.value = data.total_amount_per_movie_by_theater


        })
        .catch(error => {

            const errorMessage = error.response?.data?.message || "Failed to retrieve payments. Please try again.";

            toast.error(errorMessage, {
                 hideProgressBar: true,
            });
        });
    }


});
</script>

<template>
    <Head title="Welcome" />

    <div class="bg-blue-300 min-h-screen">
        <div class="p-5">
            <div class="text-center text-3xl">
                Movie Test
            </div>
            <div class="text-center my-4">
                <InputLabel>Select Date</InputLabel>
                <select v-model="selectedDate" class="rounded border-none">
                    <option disabled value="">Select a date</option>
                    <option v-for="date in dates" :key="date" :value="date">{{ date }}</option>
                </select>
            </div>

            <div class="bg-blue-400 rounded  text-center p-3 my-4">
                <div class="text-3xl">Movies</div>
                <div class="grid md:grid-cols-3 grid-cols-2 gap-4 my-4">

                    <div class="rounded border shadow p-2 text-center" :key="movie.movie_id" v-for="movie in total_amount_per_movie">

                        <div class="text-3xl">{{ formatCurrency(movie.total_amount) }}</div>
                        <div>{{ movie.movie.title }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-blue-400 rounded  text-center p-3 my-4">
                <div class="text-3xl">Theaters</div>
                <div class="grid md:grid-cols-2 grid-cols-2 gap-4 my-4">

                <div class="rounded border shadow p-2 text-center" :key="theater.theater_id" v-for="theater in total_amount_per_theater">

                    <div class="text-3xl">{{ formatCurrency(theater.total_amount) }}</div>
                    <div>{{ theater.theater.name }}</div>

                </div>
            </div>
            </div>

            <div class="bg-blue-400 rounded  text-center p-3 my-4">
                <div class="text-3xl">Movie by Theater</div>
                <div class="grid md:grid-cols-2 grid-cols-2 gap-4 my-4">

                <div class="rounded border shadow p-2 text-center" :key="theater.theater_id" v-for="theater in total_amount_per_movie_by_theater">

                    <div class="text-3xl mb-4">{{ theater.theater.name }}</div>

                    <div class="rounded border shadow p-2 text-center" :key="movie.movie_id" v-for="movie in theater.movies ">

                        <div class="text-3xl">{{ formatCurrency(movie.total_amount) }}</div>
                        <div>{{ movie.movie.title }}</div>
                    </div>
                </div>
            </div>
            </div>


            <div class="grid md:grid-cols-4 grid-cols-2 gap-4">
                <div class="rounded border shadow p-2 text-center">
                    <div class="text-3xl">{{ counts.movies }}</div>
                    <div>Movies</div>
                </div>
                 <div class="rounded border shadow p-2 text-center">
                    <div class="text-3xl">{{ counts.theaters }}</div>
                    <div>Theaters</div>
                </div>
                <div class="rounded border shadow p-2 text-center">
                    <div class="text-3xl">{{ counts.users }}</div>
                    <div>Users</div>
                </div>
                <div class="rounded border shadow p-2 text-center">
                    <div class="text-3xl">{{ dataCount }}</div>
                    <div>Payments</div>
                </div>
            </div>

            <DataTable
                class="p-4 mx-5"
                v-if="records"
                :label="'Payments'"
                :columns="columns"
                :records="records"
                :itemsTotal="dataCount"
                :add="false"
                :edit="false"
                :delete_="false"
                :action="false"

            >

             <template #amount="{ item }">
                <div class="flex">
                    {{ formatCurrency(item.amount)}}
                </div>
            </template>

            <template #movie="{ item }">
                <div class="flex">
                    {{ item.movie.title }}
                </div>
            </template>

             <template #user="{ item }">
                <div class="flex">
                    {{ item.user.name }}
                </div>
            </template>
             <template #theater="{ item }">
                <div class="flex">
                    {{ item.theater.name }}
                </div>
            </template>

            </DataTable>
        </div>
    </div>
</template>
