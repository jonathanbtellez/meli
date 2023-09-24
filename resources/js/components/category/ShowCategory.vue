<template>
	<nav-bar :products="products" :user="user" title="categories" />
	<section>
		<div class="card container my-4">
			<div class="card-header bg-light d-flex justify-content-end">
				<button class="btn btn-primary" @click="createCategory">Create category</button>
			</div>
			<div class="card-body">
				<div class="table-responsive my-4 mx-2">
					<table class="table table-bordered table-light table-striped" id="category_table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody @click="handleAction">
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div v-if="load_modal">
			<category-modal :category_data="category_data" />
		</div>
	</section>
	<v-footer />
</template>
<script>
import { handlerErrors, deleteMessage } from '@/helper/Alerts.js'
import useToast from '@/composables/useToast.js'
import useHandlerModal from '@/composables/useHandlerModal.js'
import CategoryModal from './CategoryModal.vue'
import { ref, onMounted } from 'vue'
export default {
	components: {
		CategoryModal
	},
	props: ['user', 'products'],
	setup(props) {
		const table = ref(null)
		const category_data = ref()

		const { openModal, load_modal, closeModal } = useHandlerModal()
		const { openFunctionToast } = useToast()
		onMounted(() => index());
		const index = () => mountedTable()

		/**
 * Create a datatable show the info receive of the backend
 */
		const mountedTable = () => {
			table.value = $('#category_table').DataTable({
				destroy: true,
				processing: true,
				serverSide: true,
				scrollX: true,
				order: [[0, 'asc']],
				autoWidth: false,
				dom: 'Bfrtip',
				buttons: ['pageLength', 'excel', 'pdf', 'copy'],
				ajax: `/categories/get-all-dt`,
				columns: [
					{ data: 'name', name: 'Name', orderable: true, searchable: true },
					{
						name: 'action',
						orderable: false,
						searchable: false,
						render: (data, type, row, meta) => {
							return `
							<div class="d-flex justify-content-center" data-role='actions'>
		            			<button onclick='event.preventDefault();' data-id='${row.id}' role='edit' class="btn btn-warning btn-sm">
		              				<i class='fas fa-pencil-alt' data-id='${row.id}' role='edit'></i>
								</button>
		            			<button onclick='event.preventDefault();' data-id='${row.id}' role='delete' class="btn btn-danger btn-sm ms-1">
		            				<i class='fas fa-trash-alt' data-id='${row.id}' role='delete'></i>
								</button>
		          			</div>`
						}
					}
				]
			})
		}

		/**
 * Open the modal component needed to create a new register
 */
		const createCategory = async () => {
			category_data.value = null
			await openModal('category_modal')
		}

		/**
		 * Receive the event click in the data base and handle which action going to be dispatch
		 * @param {*} event
		 */
		const handleAction = (event) => {
			const button = event.target
			const user_id = button.getAttribute('data-id')
			if (button.getAttribute('role') == 'edit') {
				editCategory(user_id)
			} else if (button.getAttribute('role') == 'delete') {
				deleteCategory(user_id)
			}
		}

		/**
 * Show the modal with the register obtain of the http request
 * @param {*} event
 */
		const editCategory = async (id) => {
			try {
				const { data } = await axios.get(`/categories/${id}`)
				category_data.value = data
				await openModal('category_modal')
			} catch (error) {
				await handlerErrors(error)
			}
		}

		// Send and http request to delete a register
		const deleteCategory = async (id) => {
			if (!await deleteMessage()) return
			try {
				await axios.delete(`/categories/${id}`)
				await openFunctionToast('Category deleted successful', 'success', reloadState())
			} catch (error) {
				await handlerErrors(error)
			}
		}

		const reloadState = () => {
			table.value.destroy()
			index()
		}

		// index()
		return {
			category_data,
			createCategory,
			handleAction,
			load_modal,
			reloadState,
			closeModal
		}
	}
}
</script>

