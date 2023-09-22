<template >
	<!-- Modal -->
	<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
		aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="staticBackdropLabel">{{ is_created ? 'Create' : 'Edit' }} user</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<!-- Errors -->
				<!-- <backend-error :errors="back_errors" /> -->
				<Form :validation-schema="schema" @submit="create_user">
					<div class="modal-body">

						<!-- image -->
						<div class="col-12 d-flex justify-content-center mt-1">
							<img :src="image_preview" alt="User image" class="img-thumbnail" width="170" height="170" />
						</div>

						<!-- Load Image -->
						<div class="col-12 mt-2">
							<label for="image" class="form-label">Image</label>
							<input type="file" :class="`form-control ${back_errors['image'] ? 'is-invalid' : ''}`"
								id="image" accept="image/*" @change="preview_image">
							<span class="invalid-feedback" v-if="back_errors['image']">
								{{ back_errors['image'] }}
							</span>
						</div>

						<!-- last name -->
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

						<!-- Author -->
						<!-- <div class="col-12 mt-2">
							<Field name="author" v-slot="{ errorMessage, field, valid }" v-model="author">
								<label for="author">Autor</label>

								<vue-select :options="authors_data" label="name" v-model="author"
									:reduce="author => author.id" v-bind="field" placeholder="Seleccione autor"
									:clearable="false"
									:class="`${errorMessage || back_errors['author'] ? 'is-invalid' : ''}`">
								</vue-select>
								<span class="invalid-feedback" v-if="!valid">{{ errorMessage }}</span>
								<span class="invalid-feedback" v-if="!valid">{{ back_errors['author'] }}</span>
							</Field>
						</div> -->

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

						<!-- password  confirmation-->
						<div class="col-12 mt-2">
							<label for="password_confirmation">confirm your password_confirmation:</label>
							<Field name="password_confirmation" v-slot="{ errorMessage, field }"
								v-model="user.password_confirmation">
								<input type="text" id="password_confirmation" v-model="user.password_confirmation"
									:class="`form-control ${errorMessage || back_errors['password_confirmation'] ? 'is-invalid' : ''}`"
									v-bind="field">
								<span class="invalid-feedback">{{ errorMessage }}</span>
								<span class="invalid-feedback">{{ back_errors['password_confirmation'] }}</span>
							</Field>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</Form>
			</div>
		</div>
	</div>
</template>
<script>
import { Field, Form, } from 'vee-validate'
import * as yup from 'yup';
import { computed, ref } from 'vue';
import { handlerErrors } from '@/helper/Alerts.js'
export default {
	components: {
		Field, Form,
	},
	// props: ['user_data'],
	setup(props) {
		const is_created = ref(true)
		const image_preview = ref('/storage/images/users/default.png')
		const back_errors = ref({})
		const image = ref(null)
		const user = ref({})

		const schema = computed(() => {
			return yup.object({
				name: yup.string().required(),
				last_name: yup.string().required(),
				email: yup.string().required().email(),
				password: yup.string().required()
			})
		})

		const preview_image = (event) => {
			image.value = event.target.files[0]
			image_preview.value = URL.createObjectURL(image.value)
		}

		const create_user = () => {
			// try {
			console.log(user.value);
			// } catch (error) {
			// 	back_errors.value = await handlerErrors(error)
			// }
		}

		return {
			schema,
			image_preview,
			is_created,
			back_errors,
			preview_image,
			user,
			create_user
		}
	}

}
</script>
<style ></style>
