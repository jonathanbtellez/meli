<template>
	<nav-bar :products="products" :user="user" :title="user.name" />
	<section>
		<div class="card container my-4">
			<div class="card-header bg-light d-flex justify-content-end">
				<button class="btn btn-primary" @click="createUser">Create user</button>
			</div>
			<div class="card-body">
				<div class="table-responsive my-4 mx-2">
					<table class="table table-bordered table-light table-striped" id="user_table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Role</th>
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
			<user-modal :roles_data="roles" :user_data="user_data" />
		</div>
	</section>
	<v-footer />
</template>
<script>
import { handlerErrors, deleteMessage } from '@/helper/Alerts.js'
import useToast from '@/composables/useToast.js'
import useHandlerModal from '@/composables/useHandlerModal.js'
import UserModal from './UserModal.vue'
import { ref, onMounted } from 'vue'
export default {
	components: {
		UserModal
	},
	props: ['user', 'products', 'roles'],
	setup(props) {
		const table = ref(null)
		const user_data = ref()

		const { openModal, load_modal, closeModal } = useHandlerModal()
		const {openFunctionToast} = useToast()
		onMounted(() => index());
		const index = () => mountedTable()

		const mountedTable = () => {
			table.value = $('#user_table').DataTable({
				destroy: true,
				processing: true,
				serverSide: true,
				scrollX: true,
				order: [[0, 'asc']],
				autoWidth: false,
				dom: 'Bfrtip',
				buttons: ['pageLength', 'excel', 'pdf', 'copy'],
				ajax: `/user/get-all-dt`,
				columns: [
					{ data: 'full_name', name: 'Name', orderable: true, searchable: true },
					{ data: 'roles[0].name', name: 'Role', orderable: false, searchable: false },
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

		const createUser = async () => {
			user_data.value = null
			await openModal('user_modal')
		}

		const handleAction = (event) => {
			const button = event.target
			const user_id = button.getAttribute('data-id')
			if (button.getAttribute('role') == 'edit') {
				editUser(user_id)
			} else if (button.getAttribute('role') == 'delete') {
				deleteUser(user_id)
			}
		}

		const editUser = async (id) => {
			try {
				const { data } = await axios.get(`/user/${id}`)
				user_data.value = data
				await openModal('user_modal')
			} catch (error) {
				await handlerErrors(error)
			}
		}


		const deleteUser = async (id) => {
			if (!await deleteMessage()) return
			try {
				await axios.delete(`/user/${id}`)
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
			user_data,
			createUser,
			handleAction,
			load_modal,
			reloadState,
			closeModal
		}
	}
}
</script>

