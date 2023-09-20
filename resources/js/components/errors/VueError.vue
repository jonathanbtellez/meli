
<template>
	<div class="container w-100 h-100 align-content-center align-items-center" v-if="is_loading">
		<div class="loader"></div>
	</div>
	<template v-else>
		<nav-bar :title="error_data.name" :products="products_data" />
		<div class="container my-5">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-baseline">
					<p class="fs-4 m-0">{{error_data.name}}</p>
					<a href="/" class="btn btn-secondary">Go home</a>
				</div>
				<div class="card-body">
					<p class="card-text text-center"><i :class="error_data.icon"></i></p>
					<p class="card-text">{{ error_data.message }}</p>
				</div>
			</div>
		</div>
	</template>
</template>
<script>
import { ref, onMounted } from 'vue'
export default {
	props: ['error'],
	setup(props) {
		const products_data = ref()
		const is_loading = ref(true)
		const error_data = ref({})

		const handleError = (error) => {
			switch (error) {
				case 403:
				error_data.value = {
						name: 'Unauthorize',
						message: 'Ops, you do not have permission to see this content please login or register',
						icon: 'fa-solid fa-ban fa-3x'
					}
					break

				case 404:
				error_data.value = {
						name: 'Not found',
						message: 'Ops, sorry content not found',
						icon: 'fa-regular fa-circle-xmark fa-3x'
					}
					break

				default:
				error_data.value = {
						name: "Undefined",
						message: 'Ops, sorry something went wrong',
						icon: 'fa-solid fa-magnifying-glass fa-3x'
					}
					break
			}
		}

		const getProducts = async () => {
			try {
				const { data: { products } } = await axios('product/get-all')
				is_loading.value = false
				products_data.value = products;
			} catch (error) {
				console.error(error);
			}
		}

		onMounted(() => {
			getProducts()
			handleError(props.error)
		})

		return {
			products_data,
			is_loading,
			error_data
		}
	}
}
</script>
<style scoped lang="scss">
.loader {
	width: 15px;
	aspect-ratio: 1;
	position: relative;
	left: 50%;
	top: 250px;
	animation: l9-0 1.5s infinite steps(2);
}

.loader::before,
.loader::after {
	content: "";
	position: absolute;
	inset: 0;
	border-radius: 50%;
	background: #000;
}

.loader::before {
	box-shadow: 26px 0;
	transform: translateX(-26px);
	animation: l9-1 .75s infinite linear alternate;
}

.loader::after {
	transform: translateX(13px) rotate(0deg) translateX(13px);
	animation: l9-2 .75s infinite linear alternate;
}
</style>