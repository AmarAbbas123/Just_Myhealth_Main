@once
    <script>
        window.JMH_ZEGO_VIRTUAL_BACKGROUND = {
            imageUrl: @js(asset('images/virtual-background.jpg')),
            blurDegree: 1,
            objectFit: 'cover',
        };

        window.loadJmhZegoBackgroundConfig = function () {
            return new Promise((resolve) => {
                const fallbackConfig = {
                    BackgroundProcessConfig: {
                        blurDegree: window.JMH_ZEGO_VIRTUAL_BACKGROUND.blurDegree || 1,
                    },
                };

                const imageUrl = window.JMH_ZEGO_VIRTUAL_BACKGROUND.imageUrl;
                if (!imageUrl) {
                    resolve(fallbackConfig);
                    return;
                }

                let settled = false;
                const finish = (config) => {
                    if (settled) return;
                    settled = true;
                    resolve(config);
                };

                const image = new Image();
                image.crossOrigin = 'anonymous';
                image.onload = () => finish({
                    BackgroundProcessConfig: {
                        source: image,
                        objectFit: window.JMH_ZEGO_VIRTUAL_BACKGROUND.objectFit || 'cover',
                    },
                });
                image.onerror = () => finish(fallbackConfig);
                image.src = imageUrl;

                setTimeout(() => finish(fallbackConfig), 3000);
            });
        };
    </script>
@endonce
