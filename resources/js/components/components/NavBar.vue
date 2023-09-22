<template>
	<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
		<div class="row w-100 m-auto m-md-0 d-md-flex align-items-center">
			<div class="col-12 col-md-4 mb-0">
				<a class="navbar-brand" href='/'>
					Meli | {{ title ?? 'Buy now' }}
				</a>
			</div>
			<div class="col-12 my-2 my-md-0 col-md-4 mb-md-0">
				<v-select class="select" :options="products" label="name" v-model="product" :reduce="product => product.id"
					placeholder="What are you looking for" :clearable="false"></v-select>
			</div>
			<div class="col-12 my-2 my-md-0 col-md-4">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
					data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="{{ __('Toggle navigation') }}">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse d-md-flex justify-content-end" id="navbarSupportedContent">
					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav ">
						<!-- Authentication Links -->
						<div v-if="!user" class="d-md-flex justify-content-end gap-2">
							<li class="nav-item">
								<a class="btn btn-primary w-100 my-2 my-md-0" href='/login'>Login</a>
							</li>
							<li class="nav-item">
								<a class="btn btn-secondary w-100" href='/register'>Register</a>
							</li>
						</div>
						<template v-else>
							<li class="nav-item dropdown">
								<a id="navbarDropdown"
									class="nav-link dropdown-toggle d-flex align-items-center justify-content-md-end"
									href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
									aria-expanded="false">
									<div class="image-container">
										<img class="w-100" :src="user.image.url" alt="avatar">
									</div>
									{{ user.full_name }}{{ ' ' }}
								</a>
								<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
									<!-- <a class="dropdown-item" href='logout' onclick="event.preventDefault();
												document.getElementById('logout-form').submit();">
												{{ __('logout') }}
											</a> -->
									<template v-if="role === 'admin'">
										<a href="/user" class="dropdown-item">
											<i class="fa-solid fa-user"></i> User
										</a>
									</template>
									<a href="/shopping" class="dropdown-item">
										<i class="fa-solid fa-cart-shopping"></i> Shopping cart
									</a>
									<button type="button" class="dropdown-item" @click="logout">
										<i class="fa-solid fa-arrow-right-from-bracket"></i> logout
									</button>

									<!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
												@csrf
											</form> -->
								</div>
							</li>
						</template>
					</ul>
				</div>
			</div>
		</div>
	</nav>
</template>
<script>
import { onMounted, ref, watch } from 'vue';
import useLocalStorage from '@/composables/useLocalStorage'
export default {
	props: ['user', 'products', 'title'],
	setup(props) {
		const { removeStorage } = useLocalStorage()
		const product = ref({})
		const role = ref();

		const go_to_product = (id) => window.location.href = `/product/${id}`

		onMounted(()=>{
			if(props.user){
				role.value = props.user.roles[0].name
			}
		})

		watch(product, (newValue) => {
			go_to_product(newValue);
		})

		/**
		 * If the user logout clean of data in the localeStorage
		 */
		const logout = async () => {
			try {
				removeStorage('user')
				removeStorage('car')
				await axios.post('/logout', props.user)
				window.location.href = '/login'
			} catch (error) {
				console.log(error);
			}
		}

		return {
			product,
			role,
			logout,
		}
	}
}
</script>
<style lang="scss" scoped>
.image-container {
	width: 10%;
}
</style>
