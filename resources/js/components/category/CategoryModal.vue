<template >
	<!-- Modal -->
	<div class="modal fade" id="category_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
		aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="staticBackdropLabel">{{ is_created ? 'Create' : 'Edit' }} category</h1>
					<button type="button" class="btn-close" @click="closeModal" aria-label="Close">
					</button>
				</div>

				<!-- Errors -->
				<backend-error :errors="back_errors" />
				<Form :validation-schema="schema" @submit="create_category">
					<div class="modal-body">


						<!-- name -->
						<div class="col-12 mt-2">
							<label for="name">Name:</label>
							<Field name="name" v-slot="{ errorMessage, field }" v-model="category.name">
								<input type="text" id="name" v-model="category.name"
									:class="`form-control ${errorMessage || back_errors['name'] ? 'is-invalid' : ''}`"
									v-bind="field">
								<span class="invalid-feedback">{{ errorMessage }}</span>
								<span class="invalid-feedback">{{ back_errors['name'] }}</span>
							</Field>
						</div>

					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" :disabled="disable_button">Save</button>
					</div>
				</Form>
			</div>
		</div>
	</div>
</template>
<script>
import { Field, Form, } from 'vee-validate'
import * as yup from 'yup';
import { computed, ref, getCurrentInstance, onMounted } from 'vue';
import { handlerErrors } from '@/helper/Alerts.js'
import useToast from '@/composables/useToast.js'
export default {
	components: {
		Field, Form,
	},
	props: ['roles_data', 'category_data'],
	setup(props) {
		const instance = getCurrentInstance();
		const is_created = ref(true)
		const back_errors = ref({})
		const category = ref({})
		const disable_button = ref(false)
		const closeModal = () => instance.parent.ctx.closeModal()

		const { openFunctionToast } = useToast()

		/**
		 * Yup validation
		 */
		const schema = computed(() => {
			return yup.object({
				name: yup.string().required(),
			})
		})

		/**
 * handle a success response of the backend
 */
		const successResponse = () => {
			disable_button.value = true
			closeModal()
			instance.parent.ctx.reloadState()
		}

		/**
		 * Prepare the data and handle with action going to be dispatch update or create
		 */
		const create_category = async () => {
			try {
				if (is_created.value) {
					await axios.post('/categories', category.value)
				} else {
					await axios.put(`/categories/${category.value.id}`, category.value)
				}
				openFunctionToast('Register saved successful', 'success', successResponse())
			} catch (error) {
				back_errors.value = await handlerErrors(error)
			}
		}
		/**
 * Save the info that going to be render when the component is mounted
 */
		const index = () => {
			category.value = props.category_data ? props.category_data : {}
			is_created.value = props.category_data ? false : true
		}

		onMounted(() => {
			index();
		})

		return {
			schema,
			is_created,
			back_errors,
			category,
			create_category,
			disable_button,
			closeModal
		}
	}

}
</script>
