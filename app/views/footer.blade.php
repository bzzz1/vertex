@section('footer')
	<footer>
		<div class = "info_footer">
			<div class="width_960 footer_960">

				<div class="info_footer_catalog ">
					<p class = "footer_p_catalog">Каталог товаров</p>
					<ul class = "footer_ul_catalog">
						<li><a href="#">Главная</a></li><!-- Переход на страницу каталога без сортировки-->
						<li><a href="#">Барное оборудование</a></li>
						<li><a href="#">Нейстральное оборудование</a></li>
						<li><a href="#">Посуда и инвентарь</a></li>
						<li><a href="#">Посудомоечное оборудование</a></li>
						<li><a href="#">Технологическое оборудование</a></li>
						<li><a href="#">Упаковочное оборудование</a></li>
						<li><a href="#">Хлебопекарское оборудование</a></li>
						<li><a href="#">Холодильное оборудование</a></li>
					</ul>
				</div><!-- info_footer_catalog -->

				<div class="info_footer_services">
					<p class = "footer_p_services">Услуги </p>
					<ul class = "footer_ul_services">
						<li><a href="#">Проектирование</a></li> <!-- форма обратной связи -->
						<li><a href="#">Лизинг</a></li><!-- форма обратной связи -->
						<li><a href="#">Дизайн ресторанов и кафе</a></li><!-- на страницу "информация" -->
						<li><a href="#">Внедрение систем лояльности клиентов</a></li><!-- форма обратной связи -->
						<li><a href="#">Выпечка и полуфабрикаты</a></li><!-- загрузка прайса(файл в чате) -->
					</ul>
				</div><!-- info_footer_services -->
				
				<div class = "info_footer_contacts">
					<p class="footer_contacts_p_head">Контакты</p>
					<p class="footer_contacts_p">Офис продаж</p>
					<p class="footer_contacts_p">+7(861)203-40-97</p>
					<p class="footer_contacts_p">Заказать</p> 
					<p class="footer_contacts_p"> обраный звонок</p>
				</div>
			</div><!-- width_960 footer_960 -->
		</div><!-- info_footer -->
		<div class="footer_copyright">
			<div class="width_960 footer_width_960">	
				<div class="footer_logo_div">
					<a href="{{ URL::to('/') }}">
						{{ HTML::image('icons/logo_footer.png', 'Vertex - Комплексное оснащение баров, ресторанов, кафе, пищевых производств и магазинов', ['class'=>'footer_logo']) }} 
					</a>
				</div>	
				<p class="footer_copyright_p">© 2014 «Vertex.ltd&#187 <br/>Оборудование для ресторанов, посуда для кафе и столовых, мебель для общепита,
				<br/> кухонный инвентарь
				<br/> made by <a href="http://www.bzzz.biz.ua">[bzzz!]* web development studio</a></p>
			</div><!-- width_960 -->
		</div><!-- footer_copyright -->
	</footer>
@stop