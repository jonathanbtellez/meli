<template>
	<div class="banner">
	</div>
</template>
<style lang="scss" scoped>
.banner {
	width: 100%;
	min-height: 20vh;
	margin-bottom: .5rem;
	background-image: url('/storage/project/banner.jpg');
	background-attachment: local;
	background-repeat: repeat-x;
	background-size: contain;
}

@media (min-width: 768px) {
	.banner {
		min-height: 30vh;
	}
}
@media (min-width: 768px) {
	.banner {
		min-height: 45vh;
	}
}
</style>
