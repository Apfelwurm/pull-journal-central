
<script setup>

import { reactive, ref, watch, computed } from 'vue';
import { router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue';
import Checkbox from '@/Components/Checkbox.vue';
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import debounce from 'lodash.debounce'

const props = defineProps({
  logEntries: Object,
  filters: Object,
});

const aknowledgeLogEntry = (logEntry) => {
  if (!confirm('Are you sure want to aknowledge the entry?')) return;
  router.get(route('logEntries.aknowledge', logEntry.id), {
    _token: props.csrf_token
  });
};

const unaknowledgeLogEntry = (logEntry) => {
  if (!confirm('Are you sure want to unaknowledge the entry?')) return;
  router.get(route('logEntries.unaknowledge', logEntry.id), {
    _token: props.csrf_token
  });
};




const filter_id = ref(props.filters?.id)
const filter_source = ref(props.filters?.source)
const filter_class = ref(props.filters?.class)
const filter_device = ref(props.filters?.device)
const filter_aknowledged = ref(props.filters?.aknowledged)
const filter_not_aknowledged = ref(props.filters?.not_aknowledged)

const filters = reactive({
  id: filter_id,
  source: filter_source,
  class: filter_class,
  device: filter_device,
  aknowledged: filter_aknowledged,
  not_aknowledged: filter_not_aknowledged,
});


const searchIds = computed(() => {
  if (filter_id.value === '') {
    return []
  }

  let matches = 0

  return props.logEntries.data.filter(logEntry => {
	if (
		logEntry.id.toString().toLowerCase() == filter_id.value.toLowerCase()
    ) {
      return logEntry
    }

    if (
		logEntry.id.toString().toLowerCase().includes(filter_id.value.toLowerCase())
      && matches < 10
    ) {
      matches++
      return logEntry
    }

  })
});

const selectId = (logEntry) => {
	
	filter_id.value = logEntry.id.toString()
}


const checkAknowledged = () => {

	if (filter_not_aknowledged.value == true) {
		filter_not_aknowledged.value = false
  	}
}

const checkNotAknowledged = () => {

if (filter_aknowledged.value == true) {
	filter_aknowledged.value = false
  }

}

watch(filters, debounce(() => {
	router.get(route('logEntries.index'), {filters: filters}, {preserveState: true, preserveScroll: true, only: ['logEntries']})
}, 300));

</script>

<template>
	<AppLayout title="Logs">

		<template #header>
			<h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800">
				<p>
					Logs
					<i class="fa-solid fa-logEntry-group"></i>
				</p>

				

			</h2>
		</template>

		<div class="py-12">

			<div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
				<div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">



					<div class="flex justify-end mt-3">
						<div class="mb-3 xl:w-96">
						
						</div>
					</div>
					<table class="min-w-full divide-y divide-gray-200">
                        <caption style="display: none;">Filters</caption>
						<thead class="bg-gray-50">
							<tr>
								<th scope="col" class="relative px-6 py-3">
									<span>Filters</span><br>
									<div class="text-xs font-small">Wildcard: %</div>
								</th>
								<th scope="col"
									class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									<input
									type="text"
									id="filter_id"
									placeholder="Id..."
									v-model="filter_id"
									>
									
								</th>
								<th scope="col"
									class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									<input
									type="text"
									id="filter_device"
									placeholder="Device..."
									v-model="filter_device"
									>
								</th>
								<th scope="col"
									class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									<input
									type="text"
									id="filter_source"
									placeholder="source..."
									v-model="filter_source"
									>
								</th>
								<th scope="col"
									class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									<input
									type="text"
									id="filter_class"
									placeholder="class..."
									v-model="filter_class"
									>
								</th>
                                <th scope="col"
									class="px-3 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Akn <br><Checkbox
										id="filter_aknowledged"
										v-model:checked="filter_aknowledged"
										title="only Aknowledged"
										@click="checkAknowledged()"
									/>
									
								</th>
								
                                <th scope="col"
									class="px-3 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									NAkn <br><Checkbox
										id="filter_not_aknowledged"
										v-model:checked="filter_not_aknowledged"
										title="not Aknowledged"
										@click="checkNotAknowledged()"
									/>
									
								</th>
								
							</tr>
						</thead>
					</table>

					<table class="min-w-full divide-y divide-gray-200">
                        <caption style="display: none;">Log listing</caption>
						<thead class="bg-gray-50">
							<tr>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									ID
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Device
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Source
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Class
								</th>
                                <th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Aknowledged
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Created at
								</th>
								<th scope="col" class="relative px-6 py-3">
									<span class="sr-only">Edit</span>
								</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							<tr v-for="logEntry in logEntries.data" :key="logEntry.id">
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-center text-gray-900">
												<inertia-link class="transition hover:text-blue-500"
                                                :href="`logEntries/${logEntry.id}`">{{ logEntry.id }}</inertia-link>
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="flex items-center justify-center">

										<div class="ml-4">
											<div class="text-sm font-medium text-gray-900">
												<inertia-link class="transition hover:text-blue-500"
													:href="`devices/${logEntry.device.id}`">{{ logEntry.device.name }}</inertia-link>
											</div>
										</div>
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-center text-gray-900">
										{{ logEntry.source }}
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<span v-if="logEntry.class  === 'success'"
										class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
										{{ logEntry.class }}
									</span>         
									<span v-else-if="logEntry.class  === 'info'"
										class="inline-flex px-2 text-xs font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full">
										{{ logEntry.class }}
									</span>  
									<span v-else-if="logEntry.class  === 'error'"
										class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
										{{ logEntry.class }}
									</span>    
									<span v-else-if="logEntry.class  === 'warning'"
										class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full">
										{{ logEntry.class }}
									</span>                                        

								</td>
                                <td class="px-6 py-4 whitespace-nowrap">
										<span v-if="logEntry.formatted_aknowledged_at  === 'not aknowledged'"
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-red-100 rounded-full">
                                            {{ logEntry.formatted_aknowledged_at }}
                                        </span>
                                        <div v-else>
                                        <span 
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            <div>{{ logEntry.formatted_aknowledged_at }}</div>
                                        </span>
                                            <div>by: <inertia-link class="transition hover:text-blue-500" :href="`users/${logEntry.aknowledgedfrom.id}`">{{
                                            logEntry.aknowledgedfrom.name }}</inertia-link></div>

                                        </div>
								</td>
								<td class="px-6 py-4 text-center whitespace-nowrap">
									<span
										class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
										{{ logEntry.formatted_created_at }}
									</span>
								</td>
								<td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">

									<div v-if="logEntry.formatted_aknowledged_at  === 'not aknowledged'">
                                    <a title="Aknowledge entry" @click="aknowledgeLogEntry(logEntry)"
                                        class="float-left px-4 py-2 ml-2 text-green-400 duration-100 rounded hover:text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="green" stroke="currentColor" viewBox="0 0 448 512"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                                    </a>
                                    </div>
                                    <div v-else>
                                    <a title="Unaknowledge entry" @click="unaknowledgeLogEntry(logEntry)"
                                        class="float-left px-4 py-2 ml-2 text-red-400 duration-100 rounded hover:text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="red" stroke="currentColor" viewBox="0 0 448 512"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                                    </a>
                                    </div>

								</td>
							</tr>
						</tbody>
					</table>
					<Pagination class="mt-6" :links="logEntries.meta.links" :filters="filters" />
				</div>
			</div>
		</div>
	</AppLayout>
</template>
