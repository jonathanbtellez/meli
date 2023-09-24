<template >
	<!-- Modal -->
	<div class="modal fade" id="user_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
		aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="staticBackdropLabel">{{ is_created ? 'Create' : 'Edit' }} user</h1>
					<button type="button" class="btn-close" @click="closeModal" aria-label="Close">
					</button>
				</div>

				<!-- Errors -->
				<backend-error :errors="back_errors" />
				<Form :validation-schema="schema" @submit="create_user">
					<div class="modal-body">

						<!-- image -->
						<div class="col-12 d-flex justify-content-center mt-1">
							<img :src="image_preview" alt="User image" class="img-thumbnail" width="170" height="170" />
						</div>

						<!-- Load Image -->
						<div class="col-12 mt-2">
							<label for="image" class="form-label">Image</label>
							<input type="file" :class="`form-control ${back_errors['file'] ? 'is-invalid' : ''}`"
								id="image" accept="image/*" @change="preview_image">
							<span class="invalid-feedback" v-if="back_errors['file']">
								{{ back_errors['file'] }}
							</span>
						</div>

						<!-- name -->
						<div class="col-12 mt-2">
							<label for="name">Name:</label>
							<Field name="name" v-slot="{ errorMessage, field }" v-model="user.name">
								<input type="text" id="name" v-model="user.name"
									:class="`form-control ${errorMessage || back_errors['name'] ? 'is-invalid' : ''}`"
									v-bind="field">
								<span class="invalid-feedback">{{ errorMessage }}</span>
								<span class="invalid-feedback">{{ back_errors['name'] }}</span>
							</Field>
						</div>

						<!-- Last name -->
						<div class="col-12 mt-2">
							<label for="last_name">Last name:</label>
							<Field name="last_name" v-slot="{ errorMessage, field }" v-model="user.last_name">
								<input type="text" id="last_name" v-model="user.last_name"
									:class="`form-control ${errorMessage || back_errors['last_name'] ? 'is-invalid' : ''}`"
									v-bind="field">
								<span class="invalid-feedback">{{ errorMessage }}</span>
								<span class="invalid-feedback">{{ back_errors['last_name'] }}</span>
							</Field>
						</div>

						<!-- Role -->
						<div class="col-12 mt-2">
							<Field name="role" v-slot="{ errorMessage, field, valid }" v-model="role">
								<label for="role">Role</label>
								<v-select :options="roles_data" label="name" v-model="role" :reduce="role => role.name"
									v-bind="field" placeholder="Choice a role" :clearable="false"
									:class="`${errorMessage || back_errors['role'] ? 'is-invalid' : ''}`">
								</v-select>
								<span class="invalid-feedback" v-if="!valid">{{ errorMessage }}</span>
								<span class="invalid-feedback" v-if="!valid">{{ back_errors['role'] }}</span>
							</Field>
						</div>

						<!-- email -->
						<div class="col-12 mt-2">
							<label for="email">Email:</label>
							<Field name="email" v-slot="{ errorMessage, field }" v-model="user.email">
								<input type="text" id="email" v-model="user.email"
									:class="`form-control ${errorMessage || back_errors['email'] ? 'is-invalid' : ''}`"
									v-bind="field">
								<span class="invalid-feedback">{{ errorMessage }}</span>
								<span class="invalid-feedback">{{ back_errors['email'] }}</span>
							</Field>
						</div>

						<!-- password -->
						<div class="col-12 mt-2">
							<label for="password">Password:</label>
							<Field name="password" v-slot="{ errorMessage, field }" v-model="user.password">
								<input type="text" id="password" v-model="user.password"
									:class="`form-control ${errorMessage || back_errors['password'] ? 'is-invalid' : ''}`"
									v-bind="field">
								<span class="invalid-feedback">{{ errorMessage }}</span>
								<span class="invalid-feedback">{{ back_errors['password'] }}</span>
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
	props: ['roles_data', 'user_data'],
	setup(props) {
		const instance = getCurrentInstance();
		const is_created = ref(true)
		const image_preview = ref('')
		const back_errors = ref({})
		const image = ref(null)
		const user = ref({})
		const role = ref()
		const disable_button = ref(false)
		const closeModal = () => instance.parent.ctx.closeModal()

		const { openFunctionToast } = useToast()

		const schema = computed(() => {
			return yup.object({
				name: yup.string().required(),
				last_name: yup.string().required(),
				role: yup.string().required(),
				email: yup.string().required().email(),
				password: yup.string().required()
			})
		})

		const preview_image = (event) => {
			image.value = event.target.files[0]
			image_preview.value = URL.createObjectURL(image.value)
		}

		const createFormData = (data) => {
			const form_data = new FormData()

			if (image.value) {
				form_data.append('file', image.value, image.value.name)
			}
			for (const prop in data) {
				form_data.append(prop, data[prop])
			}
			return form_data
		}

		const successResponse = () => {
			disable_button.value = true
			closeModal()
			instance.parent.ctx.reloadState()
		}

		const create_user = async () => {
			try {
				user.value.role = role.value
				user.value.password_confirmation = user.value.password
				const userData = createFormData(user.value)

				if (is_created.value) {
					await axios.post('/user', userData)
				} else {
					await axios.post(`/user/${user.value.id}`, userData)
				}
				openFunctionToast('Register saved successful', 'success', successResponse())
			} catch (error) {
				back_errors.value = await handlerErrors(error)
			}
		}
		const index = () => {
			user.value = props.user_data ? props.user_data : {}
			image_preview.value = props.user_data ? props.user_data.image.url : '/storage/images/users/default.png'
			is_created.value = props.user_data ? false : true
		}

		onMounted(() => {
			index();
		})

		return {
			schema,
			image_preview,
			is_created,
			back_errors,
			preview_image,
			user,
			create_user,
			role,
			disable_button,
			closeModal
		}
	}

}
</script>
<style ></style>
