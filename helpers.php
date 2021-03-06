<?php

if ( ! function_exists('sanitizer')) {
    /**
     * Get the sanitizer factory instance.
     *
     * @return \Arcanedev\Sanitizer\Factory
     */
    function sanitizer() {
        return app(Arcanedev\Sanitizer\Contracts\Sanitizer::class);
    }
}
