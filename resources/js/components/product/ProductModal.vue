<template >
	<!-- Modal -->
	<div class="modal fade" id="product_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
		aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="staticBackdropLabel">{{ is_created ? 'Create' : 'Edit' }} product</h1>
					<button type="button" class="btn-close" @click="closeModal" aria-label="Close">
					</button>
				</div>

				<!-- Errors -->
				<!-- <backend-error :errors="back_errors" /> -->
				<Form :validation-schema="schema" @submit="create_product">
					<div class="modal-body">

						<!-- image -->
						<div class="col-12 d-flex justify-content-center mt-1">
							<img :src="image_preview" alt="Product image" class="img-thumbnail" width="170" height="170" />
						</div>

						<!-- Load Image -->
						<div class="col-12 mt-2">
							<label for="image" class="form-label">Image</label>
							<input type="file" :class="`form-control ${back_errors['file'] ? 'is-invalid' : ''}`" id="image"
								accept="image/*" @change="preview_image">
							<span class="invalid-feedback" v-if="back_errors['file']">
								{{ back_errors['file'] }}
							</span>
						</div>

						<!-- name -->
						<div class="col-12 mt-2">
							<label for="name">Name:</label>
							<Field name="name" v-slot="{ errorMessage, field }" v-model="product.name">
								<input type="text" id="name" v-model="product.name"
									:class="`form-control ${errorMessage || back_errors['name'] ? 'is-invalid' : ''}`"
									v-bind="field">
								<span class="invalid-feedback">{{ errorMessage }}</span>
								<span class="invalid-feedback">{{ back_errors['name'] }}</span>
							</Field>
						</div>

						<!-- Description -->
						<div class="col-12 mt-2">
							<label for="description">Description:</label>
							<Field name="description" v-slot="{ errorMessage, field }" v-model="product.description">
								<input type="text" id="description" v-model="product.description"
									:class="`form-control ${errorMessage || back_errors['description'] ? 'is-invalid' : ''}`"
									v-bind="field">
								<span class="invalid-feedback">{{ errorMessage }}</span>
								<span class="invalid-feedback">{{ back_errors['description'] }}</span>
							</Field>
						</div>

						<!-- Stock -->
						<div class="col-12 mt-2">
							<label for="stock">Stock:</label>
							<Field name="stock" v-slot="{ errorMessage, field }" v-model="product.stock">
								<input type="number" id="stock" v-model="product.stock"
									:class="`form-control ${errorMessage || back_errors['stock'] ? 'is-invalid' : ''}`"
									v-bind="field">
								<span class="invalid-feedback">{{ errorMessage }}</span>
								<span class="invalid-feedback">{{ back_errors['stock'] }}</span>
							</Field>
						</div>

						<!-- price -->
						<div class="col-12 mt-2">
							<label for="price">Price:</label>
							<Field name="price" v-slot="{ errorMessage, field }" v-model="product.price">
								<input type="number" id="price" v-model="product.price"
									:class="`form-control ${errorMessage || back_errors['price'] ? 'is-invalid' : ''}`"
									v-bind="field">
								<span class="invalid-feedback">{{ errorMessage }}</span>
								<span class="invalid-feedback">{{ back_errors['price'] }}</span>
							</Field>
						</div>

						<!-- category -->
						<div class="col-12 mt-2">
							<Field name="category" v-slot="{ errorMessage, field, valid }" v-model="category">
								<label for="category">category</label>
								<v-select :options="categories_data" label="name" v-model="category" :reduce="category => category.id"
									v-bind="field" placeholder="Choice a category" :clearable="false"
									:class="`${errorMessage || back_errors['category'] ? 'is-invalid' : ''}`">
								</v-select>
								<span class="invalid-feedback" v-if="!valid">{{ errorMessage }}</span>
								<span class="invalid-feedback" v-if="!valid">{{ back_errors['category'] }}</span>
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
	props: ['categories_data', 'product_data'],
	setup(props) {
		const instance = getCurrentInstance();
		const is_created = ref(true)
		const image_preview = ref('')
		const back_errors = ref({})
		const image = ref(null)
		const product = ref({})
		const category = ref()
		const disable_button = ref(false)
		const closeModal = () => instance.parent.ctx.closeModal()

		const { openFunctionToast } = useToast()

		const schema = computed(() => {
			return yup.object({
				name: yup.string().required(),
				description: yup.string().required(),
				stock: yup.number().required(),
				price: yup.number().positive().required(),
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

		const create_product = async () => {
			try {
				product.value.category_id = category.value
				const productData = createFormData(product.value)
				if (is_created.value) {
					await axios.post('/products', productData)
				} else {
					await axios.post(`/products/${product.value.id}`, productData)
				}
				openFunctionToast('Register saved successful', 'success', successResponse())
			} catch (error) {
				back_errors.value = await handlerErrors(error)
			}
		}
		const index = () => {
			product.value = props.product_data ? props.product_data : {}
			image_preview.value = props.product_data ? props.product_data.image.url : '/storage/images/products/default.png'
			is_created.value = props.product_data ? false : true
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
			product,
			create_product,
			category,
			disable_button,
			closeModal
		}
	}

}
</script>
<style ></style>
