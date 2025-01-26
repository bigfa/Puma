class pumaPost extends pumaBase {
    loading = false;
    page = 1;
    button: any;
    constructor() {
        super();
        this.init();
    }

    init() {
        if (document.querySelector('.loadmore')) {
            this.button = document.querySelector('.loadmore');
            document.querySelector('.loadmore')?.addEventListener('click', (e) => {
                e.preventDefault();
                if (this.loading) return;
                this.loading = true;
                this.page++;
                this.fetchPosts();
            });
        }
    }

    randerPosts(data: any) {
        let html = data
            .map((post: any) => {
                const thumbnail = //@ts-ignore
                    obvInit.hide_home_cover || !post.has_image
                        ? ''
                        : `<a href="${post.permalink}" aria-label="${post.post_title}" class="cover--link">
                <img src="${post.thumbnail}" class="cover" alt="${post.post_title}">
                        </a>`;
                return post.post_format && post.post_format == 'status'
                    ? `<article class="post--item post--item__status" itemtype="http://schema.org/Article" itemscope="itemscope">
    <div class="content">
        <header>
            <img alt="" src="${post.author_avatar_urls}" class="avatar avatar-48 photo" height="48" width="48" decoding="async">            <a itemprop="datePublished" datetime="" class="humane--time" href="${post.permalink}" aria-label="${post.post_title}">${post.date}</a>
        </header>
                    <div class="description" itemprop="about"><p>${post.excerpt}</p>
</div>
            </div>
</article>`
                    : `<article class="post--item" itemtype="http://schema.org/Article" itemscope="itemscope">
            <div class="content">
                <h2 class="post--title" itemprop="headline">
                    <a href="${post.permalink}" aria-label="${post.post_title}">
                        ${post.post_title}</a>
                </h2>
                <div class="description" itemprop="about">${post.excerpt}</div>
                <div class="meta">
                    <svg class="icon" viewBox="0 0 1024 1024" width="16" height="16">
                        <path d="M512 97.52381c228.912762 0 414.47619 185.563429 414.47619 414.47619s-185.563429 414.47619-414.47619 414.47619S97.52381 740.912762 97.52381 512 283.087238 97.52381 512 97.52381z m0 73.142857C323.486476 170.666667 170.666667 323.486476 170.666667 512s152.81981 341.333333 341.333333 341.333333 341.333333-152.81981 341.333333-341.333333S700.513524 170.666667 512 170.666667z m36.571429 89.697523v229.86362h160.865523v73.142857H512a36.571429 36.571429 0 0 1-36.571429-36.571429V260.388571h73.142858z"></path>
                    </svg>
                    <time itemprop="datePublished" datetime="" class="humane--time">${post.date}</time>
                                                    </div>
            </div>${thumbnail}
            </article>`;
            })
            .join('');
        // @ts-ignore
        document.querySelector('.posts--list')?.innerHTML += html;
    }

    randerCardPosts(data: any) {
        let html = data
            .map((post: any) => {
                return `<article class="post--card" itemtype="http://schema.org/Article" itemscope="itemscope">
            <a href="${post.permalink}" title="${post.post_title}" aria-label="${post.post_title}" class="cover--link">
            <img src="${post.thumbnail}" class="cover" alt="${post.post_title}">
        </a>
        <div class="content">
        <div class="date">${post.day}</div>
        <h2 class="post--title" itemprop="headline">
            <a href="${post.permalink}" title="${post.post_title}" aria-label="${post.post_title}">${post.post_title}</a>
        </h2>
                    <div class="description" itemprop="about">
                    ${post.excerpt}
            </div>
                <div class="meta">
            <svg class="icon" viewBox="0 0 1024 1024" width="16" height="16">
                <path d="M512 97.52381c228.912762 0 414.47619 185.563429 414.47619 414.47619s-185.563429 414.47619-414.47619 414.47619S97.52381 740.912762 97.52381 512 283.087238 97.52381 512 97.52381z m0 73.142857C323.486476 170.666667 170.666667 323.486476 170.666667 512s152.81981 341.333333 341.333333 341.333333 341.333333-152.81981 341.333333-341.333333S700.513524 170.666667 512 170.666667z m36.571429 89.697523v229.86362h160.865523v73.142857H512a36.571429 36.571429 0 0 1-36.571429-36.571429V260.388571h73.142858z"></path>
            </svg>
            <time itemprop="datePublished" datetime="" class="humane--time">${post.date}</time>
            <svg class="icon" viewBox="0 0 1024 1024" width="16" height="16">
                <path d="M669.013333 596.21181l194.389334 226.791619A77.433905 77.433905 0 0 1 804.59581 950.857143H212.016762a77.433905 77.433905 0 0 1-58.782476-127.853714l194.413714-226.791619c22.918095 13.897143 47.737905 24.941714 74.044952 32.597333l-209.67619 244.614095h592.579048l-209.676191-244.614095a308.102095 308.102095 0 0 0 74.069333-32.597333zM508.294095 73.142857c142.57981 0 258.145524 115.565714 258.145524 258.145524 0 142.57981-115.565714 258.145524-258.145524 258.145524-142.57981 0-258.145524-115.565714-258.145524-258.145524C250.148571 188.732952 365.714286 73.142857 508.318476 73.142857z m0 77.433905a180.711619 180.711619 0 1 0 0 361.423238 180.711619 180.711619 0 0 0 0-361.423238z"></path>
            </svg>
            <a href="${post.author_posts_url}">${post.author}</a>
                    </div>
    </div>
</article>`;
            })
            .join('');
        // @ts-ignore
        document.querySelector('.post--cards')?.innerHTML += html;
    }

    fetchPosts() {
        this.button.innerHTML = '加载中...';
        let params: any = {
            page: this.page,
            category: '',
            tag: '',
            author: '',
        };
        if (this.button.dataset.category) {
            params.category = this.button.dataset.category;
        }

        if (this.button.dataset.tag) {
            params.tag = this.button.dataset.tag;
        }

        if (this.button.dataset.author) {
            params.author = this.button.dataset.author;
        }

        const fecthParmas = new URLSearchParams(params).toString();

        // @ts-ignore
        fetch(obvInit.restfulBase + 'puma/v1/posts?' + fecthParmas, {
            method: 'get',
            headers: {
                // @ts-ignore
                'X-WP-Nonce': obvInit.nonce,
                'Content-Type': 'application/json',
            },
        })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                this.loading = false;
                if (data.code != 200) {
                    return this.showNotice(data.message, 'error');
                } else {
                    if (data.data.length == 0) {
                        document.querySelector('.loadmore')?.remove();
                        this.showNotice('没有更多文章了', 'error');
                    } else {
                        if (document.querySelector('.posts--list')) {
                            this.randerPosts(data.data);
                        } else {
                            this.randerCardPosts(data.data);
                        }
                        this.showNotice('加载成功', 'error');
                    }
                    this.button.innerHTML = '加载更多';
                }
            });
    }
}
new pumaPost();
