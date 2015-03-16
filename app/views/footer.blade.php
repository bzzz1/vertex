@section('footer')
	<footer>
		<div class = "info_footer">
			<div class="width_960 footer_960">

				<div class="info_footer_catalog ">
					<p class = "footer_p_catalog">Каталог товаров</p>
					<ul class = "footer_ul_catalog">
						<li>{{ HTML::link('', 'Главная', ['class'=>'']) }}</li>
						<li>{{ HTML::link('/items/Барное/Всё', 'Барное оборудование', ['class'=>'']) }}</li>
						<li>{{ HTML::link('/items/Нейтральное/Всё', 'Нейтральное оборудование', ['class'=>'']) }}</li>
						<li>{{ HTML::link('/items/Посуда и инвентарь/Всё', 'Посуда и инвентарь', ['class'=>'']) }}</li>
						<li>{{ HTML::link('/items/Посудомоечное/Всё', 'Посудомоечное оборудование', ['class'=>'']) }}</li>
						<li>{{ HTML::link('/items/Технологическое/Всё', 'Технологическое оборудование', ['class'=>'']) }}</li>
						<li>{{ HTML::link('/items/Упаковочное/Всё', 'Упаковочное оборудование', ['class'=>'']) }}</li>
						<li>{{ HTML::link('/items/Хлебопекарное/Всё', 'Хлебопекарное оборудование', ['class'=>'']) }}</li>
						<li>{{ HTML::link('/items/Холодильное/Всё', 'Холодильное оборудование', ['class'=>'']) }}</li>
					</ul>
				</div><!-- info_footer_catalog -->

				<div class="info_footer_services">
					<p class = "footer_p_services">Услуги </p>
					<ul class = "footer_ul_services">
						<li>{{ HTML::link('', 'Проектирование', ['class'=>'contact_form_button']) }}</li> <!-- форма обратной связи -->
						<li>{{ HTML::link('', 'Лизинг', ['class'=>'contact_form_button']) }}</li><!-- форма обратной связи -->
						<li>{{ HTML::link('/info', 'Дизайн ресторанов и кафе', ['class'=>'']) }}</li><!-- на страницу "информация" -->
						<li>{{ HTML::link('', 'Внедрение систем лояльности клиентов', ['class'=>'contact_form_button']) }}</li><!-- форма обратной связи -->
						<li>{{ HTML::link('/attachment', 'Выпечка и полуфабрикаты | скачать прайс', ['class'=>'']) }}</li><!-- загрузка прайса -->
					</ul>
				</div><!-- info_footer_services -->
				
				<div class = "info_footer_contacts">
					<p class="footer_contacts_p_head">Контакты</p>
					<p class="footer_contacts_p">Офис продаж</p>
					<p class="footer_contacts_p">(812) 982 33 54</p>
					<a class="footer_contacts_p contact_form_button">Заказать <br> обратный звонок</a>
					<p class="footer_contacts_p">9823354@mail.ru</p>
				</div>
			</div><!-- width_960 footer_960 -->
		</div><!-- info_footer -->
		<div class="footer_copyright">
			<div class="width_960 footer_width_960">	
				<a href="{{ URL::to('/') }}" class='footer_logo_div'>
					{{ HTML::image('icons/logo_footer.png', 'Vertex - Комплексное оснащение баров, ресторанов, кафе, пищевых производств и магазинов', ['class'=>'footer_logo']) }} 
				</a>
				<p class="footer_copyright_p">
					© 2014 «Vertex.ltd&#187 
					<br/>Оборудование для ресторанов, посуда для кафе и столовых, мебель для общепита,
					<br/> кухонный инвентарь
					<br/> made by 
					<a href="http://www.dev.bzzz.biz.ua" target="_blank">[bzzz!]* web development studio</a>
				</p>
			</div><!-- width_960 -->
		</div><!-- footer_copyright -->
	</footer>
@stop