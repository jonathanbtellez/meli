<template>
	<nav-bar :products="products" :user="user" title="Products" />
	<section>
		<div class="card container my-4">
			<div class="card-header bg-light d-flex justify-content-end">
				<button class="btn btn-primary" @click="createProduct">Create product</button>
			</div>
			<div class="card-body">
				<div class="table-responsive my-4 mx-2">
					<table class="table table-bordered table-light table-striped" id="product_table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th>Stock</th>
								<th>Price</th>
								<th>Category</th>
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
			<product-modal :categories_data="categories" :product_data="product_data" />
		</div>
	</section>
	<v-footer />
</template>
<script>
import { handlerErrors, deleteMessage } from '@/helper/Alerts.js'
import useToast from '@/composables/useToast.js'
import useHandlerModal from '@/composables/useHandlerModal.js'
import ProductModal from './ProductModal.vue'
import { ref, onMounted } from 'vue'
export default {
	components: {
		ProductModal
	},
	props: ['user', 'products', 'categories'],
	setup(props) {
		const table = ref(null)
		const product_data = ref()

		const { openModal, load_modal, closeModal } = useHandlerModal()
		const { openFunctionToast } = useToast()
		onMounted(() => index());
		const index = () => mountedTable()

		/**
 * Create a datatable show the info receive of the backend
 */
		const mountedTable = () => {
			table.value = $('#product_table').DataTable({
				destroy: true,
				processing: true,
				serverSide: true,
				scrollX: true,
				order: [[0, 'asc']],
				autoWidth: false,
				dom: 'Bfrtip',
				buttons: ['pageLength', 'excel', 'pdf', 'copy'],
				ajax: `/products/get-all-dt`,
				columns: [
					{ data: 'name', name: 'Name', orderable: true, searchable: true },
					{ data: 'format_description', name: 'Description', orderable: false, searchable: false },
					{ data: 'stock', name: 'Stock', orderable: false, searchable: false },
					{ data: 'price', name: 'Stock', orderable: false, searchable: false },
					{ data: 'category.name', name: 'Category', orderable: false, searchable: false },
					{
						name: 'action',
						orderable: false,
						searchable: false,
						render: (data, type, row, meta) => {
							return `
							<div class="d-flex justify-content-center" data-role='actions'>
								<button onclick='event.preventDefault();' data-id='${row.id}' role='see' class="btn btn-secondary btn-sm">
		              				<i class='fa-solid fa-eye' data-id='${row.id}' role='see'></i>
								</button>
		            			<button onclick='event.preventDefault();' data-id='${row.id}' role='edit' class="btn btn-warning btn-sm ms-1">
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
		const createProduct = async () => {
			product_data.value = null
			await openModal('product_modal')
		}

		/**
 * Receive the event click in the data base and handle which action going to be dispatch
 * @param {*} event
 */
		const handleAction = (event) => {
			const button = event.target
			const user_id = button.getAttribute('data-id')
			if (button.getAttribute('role') == 'edit') {
				editUser(user_id)
			}
			if (button.getAttribute('role') == 'delete') {
				deleteUser(user_id)
			}
			if (button.getAttribute('role') == 'see') {
				seeProduct(user_id);
			}
		}

		const seeProduct = (id) => {
			window.open(`/product/${id}`)
		}

		// Send and http request to delete a register
		const editUser = async (id) => {
			try {
				const { data } = await axios.get(`/products/${id}`)
				product_data.value = data
				await openModal('product_modal')
			} catch (error) {
				await handlerErrors(error)
			}
		}


		const deleteUser = async (id) => {
			if (!await deleteMessage()) return
			try {
				await axios.delete(`/products/${id}`)
				await openFunctionToast('User delete successful', 'success', reloadState())
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
			product_data,
			createProduct,
			handleAction,
			load_modal,
			reloadState,
			closeModal
		}
	}
}
</script>
