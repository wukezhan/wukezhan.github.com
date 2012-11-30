
<ul class="posts">
{% for post in site.categories[page.title] %}
    <li>
        <p class="date" cate="{{ post.categories }}">{{ post.date | date:"%Y-%m-%d" }}</p>
        <a href="{{ post.url }}">{{ post.title }}</a>
    </li>
{% endfor %} 
</ul>
