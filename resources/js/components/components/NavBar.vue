<template>
	<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
		<div class="container">
			<div>
				<a class="navbar-brand" href='/'>
					Meli | {{ title ?? 'Buy now' }}
				</a>
			</div>
			<div v-if="user" class="col-12 mb-2 col-md-4 mb-md-0">
				<v-select class="select" :options="products" label="name" v-model="product" :reduce="product => product.id"
					placeholder="What are you looking for" :clearable="false"></v-select>
			</div>
			<div>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
					data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="{{ __('Toggle navigation') }}">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav me-auto">
					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav ms-auto">
						<!-- Authentication Links -->
						<template v-if="!user">
							<li class="nav-item me-2">
								<a class="btn btn-primary" href='/login'>Login</a>
							</li>
							<li class="nav-item">
								<a class="btn btn-secondary" href='/register'>Register</a>
							</li>
						</template>
						<template v-else>
							<li class="nav-item dropdown">
								<div class="d-flex align-items-baseline">
									<div class="image-container">
										<img class="w-100" :src="user.image.url" alt="avatar">
									</div>
									<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
										data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										{{ user.full_name }}{{ ' ' }}
										<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
											<!-- <a class="dropdown-item" href='logout' onclick="event.preventDefault();
																 document.getElementById('logout-form').submit();">
											{{ __('logout') }}
										</a> -->
											<a class="dropdown-item" @click="logout">
												logout
											</a>

											<!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
											@csrf
										</form> -->
										</div>
									</a>
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
import { ref, watch } from 'vue';
export default {
	props: ['user', 'products', 'title'],
	setup(props) {
		console.log(props.user);
		const product = ref({})

		const go_to_product = (id) => window.location.href = `/product/${id}`
		watch(product, (newValue, oldValue) => {
			go_to_product(newValue);
		})

		const logout = async () => {
			try {
				await axios.post('/logout', props.user)
				window.location.href = '/login'
			} catch (error) {
				console.log(error);
			}
		}

		return {
			product,
			logout,
		}
	}
}
</script>
<style lang="scss" scoped>
.image-container {
	width: 3rem;
}
</style>
