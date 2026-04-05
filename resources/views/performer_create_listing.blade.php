@extends('componet.shablon')

@section('title', 'Создать объявление')
@section('description', 'Форма создания объявления для исполнителя')

@section('content')
<style>
  :root {
    --bg: #ececf4;
    --surface: #ffffff;
    --surface-2: #f7f8fc;
    --surface-3: #edf0f7;
    --text: #202531;
    --muted: #70778a;
    --line: #d7dceb;
    --primary: #2f80ff;
    --primary-600: #1f6ef0;
    --primary-soft: rgba(47,128,255,0.12);
    --success: #43c56a;
    --warning: #ffb648;
    --shadow: 0 14px 40px rgba(32, 37, 49, 0.08);
    --radius-xl: 28px;
    --radius-lg: 22px;
    --radius-md: 18px;
    --radius-sm: 14px;
  }

  * { box-sizing: border-box; }

  body {
    font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    background:
      radial-gradient(circle at top left, rgba(47,128,255,0.07), transparent 28%),
      linear-gradient(180deg, #eff1f8 0%, #ececf4 100%);
    color: var(--text);
    line-height: 1.4;
  }

  .performer-create-listing a { color: inherit; text-decoration: none; }
  .performer-create-listing button,
  .performer-create-listing input,
  .performer-create-listing select,
  .performer-create-listing textarea { font: inherit; }

  .performer-create-listing .page {
    max-width: 1440px;
    margin: 0 auto;
    padding: 24px;
  }

  .performer-create-listing .content {
    margin-top: 0;
    display: grid;
    grid-template-columns: minmax(0, 1fr) 360px;
    gap: 24px;
    align-items: start;
  }

  .performer-create-listing .panel {
    background: var(--surface);
    border-radius: 30px;
    padding: 26px;
    box-shadow: var(--shadow);
    border: 1px solid rgba(255,255,255,0.8);
  }

  .performer-create-listing .section-head {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    align-items: flex-start;
    margin-bottom: 22px;
    flex-wrap: wrap;
  }

  .performer-create-listing .section-head h2 {
    margin: 0;
    font-size: 30px;
    line-height: 1.05;
    letter-spacing: -0.03em;
  }

  .performer-create-listing .section-head p {
    margin: 8px 0 0;
    color: var(--muted);
    max-width: 620px;
  }

  .performer-create-listing .form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 16px;
  }

  .performer-create-listing .field {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .performer-create-listing .field.full { grid-column: 1 / -1; }

  .performer-create-listing .field label {
    font-size: 15px;
    font-weight: 800;
    color: #394356;
  }

  .performer-create-listing .optional {
    color: #9aa1b3;
    font-weight: 700;
    margin-left: 4px;
    font-size: 13px;
  }

  .performer-create-listing .control,
  .performer-create-listing .textarea,
  .performer-create-listing .select,
  .performer-create-listing .combo {
    width: 100%;
    min-height: 58px;
    border: 1px solid var(--line);
    background: var(--surface-2);
    border-radius: 18px;
    padding: 16px 18px;
    color: var(--text);
    outline: none;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.8);
  }

  .performer-create-listing .control::placeholder,
  .performer-create-listing .textarea::placeholder { color: #8f97aa; }

  .performer-create-listing .textarea {
    resize: vertical;
    min-height: 124px;
  }

  .performer-create-listing .combo-wrap {
    display: grid;
    grid-template-columns: 1fr 64px;
    gap: 10px;
  }

  .performer-create-listing .mini-add {
    height: 58px;
    border-radius: 18px;
    background: var(--primary);
    color: white;
    border: 0;
    font-size: 28px;
    box-shadow: 0 12px 24px rgba(47,128,255,0.25);
  }

  .performer-create-listing .select-wrap {
    position: relative;
  }

  .performer-create-listing .select-wrap::after {
    content: "▾";
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #7d8598;
    font-size: 18px;
    pointer-events: none;
  }

  .performer-create-listing .materials {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 12px;
  }

  .performer-create-listing .tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 999px;
    background: var(--primary-soft);
    color: var(--primary-600);
    font-weight: 700;
    font-size: 14px;
  }

  .performer-create-listing .tag span {
    display: inline-grid;
    place-items: center;
    width: 20px;
    height: 20px;
    border-radius: 999px;
    background: rgba(47,128,255,0.18);
    font-size: 12px;
  }

  .performer-create-listing .switch-row {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    align-items: center;
    margin-top: 4px;
  }

  .performer-create-listing .check {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #475063;
    font-weight: 700;
  }

  .performer-create-listing .check-box {
    width: 22px;
    height: 22px;
    border-radius: 8px;
    border: 1.8px solid #bfc7d8;
    background: white;
    position: relative;
    flex: 0 0 22px;
  }

  .performer-create-listing .check.active .check-box {
    border-color: var(--primary);
    background: rgba(47,128,255,0.08);
  }

  .performer-create-listing .check.active .check-box::after {
    content: "";
    position: absolute;
    left: 6px;
    top: 3px;
    width: 6px;
    height: 10px;
    border-right: 2px solid var(--primary);
    border-bottom: 2px solid var(--primary);
    transform: rotate(40deg);
  }

  .performer-create-listing .helper {
    margin-top: 8px;
    color: #8b93a7;
    font-size: 13px;
    line-height: 1.45;
  }

  .performer-create-listing .actions {
    margin-top: 26px;
    padding-top: 24px;
    border-top: 1px solid var(--surface-3);
    display: flex;
    justify-content: space-between;
    gap: 16px;
    align-items: center;
    flex-wrap: wrap;
  }

  .performer-create-listing .actions-left {
    color: #8790a3;
    font-size: 13px;
    font-weight: 600;
    max-width: 520px;
  }

  .performer-create-listing .actions-right {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
  }

  .performer-create-listing .actions-right .primary-btn,
  .performer-create-listing .actions-right .outline-btn {
    min-width: 220px;
    min-height: 58px;
    font-size: 16px;
  }

  .performer-create-listing .sidebar {
    display: grid;
    gap: 18px;
  }

  .performer-create-listing .upload-card {
    background:
      linear-gradient(180deg, rgba(255,255,255,0.8), rgba(247,248,252,0.95));
    border: 1px dashed rgba(47,128,255,0.24);
    border-radius: 28px;
    padding: 24px;
    box-shadow: var(--shadow);
    text-align: center;
  }

  .performer-create-listing .upload-icon {
    width: 82px;
    height: 82px;
    margin: 0 auto 16px;
    border-radius: 24px;
    background: linear-gradient(180deg, #f8fbff, #eef4ff);
    border: 1px solid rgba(47,128,255,0.14);
    display: grid;
    place-items: center;
    font-size: 34px;
    color: var(--primary);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.9);
  }

  .performer-create-listing .upload-card h3,
  .performer-create-listing .sidebar-card h3 {
    margin: 0;
    font-size: 22px;
    letter-spacing: -0.02em;
  }

  .performer-create-listing .upload-card p,
  .performer-create-listing .sidebar-card p,
  .performer-create-listing .sidebar-card li {
    color: #5e697c;
  }

  .performer-create-listing .upload-grid {
    margin-top: 18px;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
  }

  .performer-create-listing .thumb {
    position: relative;
    overflow: hidden;
    border-radius: 22px;
    min-height: 150px;
    background:
      radial-gradient(circle at 20% 18%, rgba(255,255,255,0.42), transparent 24%),
      linear-gradient(140deg, rgba(32, 90, 255, 0.86), rgba(43, 196, 159, 0.72)),
      linear-gradient(180deg, #cfd9ff, #94baff);
    box-shadow: 0 12px 26px rgba(32,37,49,0.12);
  }

  .performer-create-listing .thumb:nth-child(2) {
    background:
      radial-gradient(circle at 25% 18%, rgba(255,255,255,0.38), transparent 24%),
      linear-gradient(140deg, rgba(55,114,255,0.88), rgba(170,104,255,0.72)),
      linear-gradient(180deg, #d8ddff, #c1b0ff);
  }

  .performer-create-listing .thumb:nth-child(3) {
    background:
      radial-gradient(circle at 20% 18%, rgba(255,255,255,0.4), transparent 24%),
      linear-gradient(140deg, rgba(24,104,199,0.88), rgba(48,183,255,0.72)),
      linear-gradient(180deg, #c9edff, #8bd0ff);
  }

  .performer-create-listing .thumb::after {
    content: "";
    position: absolute;
    inset: 14px;
    border-radius: 18px;
    background:
      linear-gradient(135deg, rgba(255,255,255,0.16), rgba(255,255,255,0.04)),
      repeating-linear-gradient(135deg, rgba(255,255,255,0.24) 0 6px, rgba(255,255,255,0.03) 6px 18px);
    mix-blend-mode: screen;
  }

  .performer-create-listing .thumb-bar {
    position: absolute;
    left: 10px;
    right: 10px;
    bottom: 10px;
    padding: 10px 12px;
    border-radius: 16px;
    background: rgba(255,255,255,0.88);
    color: #405069;
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    font-weight: 700;
    backdrop-filter: blur(6px);
    z-index: 1;
  }

  .performer-create-listing .sidebar-card {
    background: var(--surface);
    border-radius: 28px;
    padding: 24px;
    box-shadow: var(--shadow);
    border: 1px solid rgba(255,255,255,0.8);
  }

  .performer-create-listing .sidebar-card ul {
    padding-left: 18px;
    margin: 14px 0 0;
    display: grid;
    gap: 10px;
  }

  .performer-create-listing .status-list {
    display: grid;
    gap: 12px;
    margin-top: 16px;
  }

  .performer-create-listing .status-item {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 18px;
    background: var(--surface-2);
    border: 1px solid var(--line);
    font-weight: 700;
    color: #42506a;
  }

  .performer-create-listing .status-item span:last-child {
    color: var(--muted);
    font-weight: 600;
  }

  .performer-create-listing .ghost-btn,
  .performer-create-listing .primary-btn,
  .performer-create-listing .outline-btn,
  .performer-create-listing .icon-btn {
    border: none;
    border-radius: 999px;
    padding: 12px 18px;
    font-weight: 700;
    cursor: pointer;
    transition: .2s ease;
  }

  .performer-create-listing .primary-btn {
    background: var(--primary);
    color: white;
    box-shadow: 0 12px 24px rgba(47,128,255,0.3);
  }

  .performer-create-listing .outline-btn {
    background: transparent;
    color: var(--text);
    border: 1.5px solid rgba(47,128,255,0.28);
    box-shadow: inset 0 0 0 1px rgba(255,255,255,0.42);
  }

  .performer-create-listing .ghost-btn:hover,
  .performer-create-listing .primary-btn:hover,
  .performer-create-listing .outline-btn:hover {
    transform: translateY(-1px);
  }

  @media (max-width: 1200px) {
    .performer-create-listing .content { grid-template-columns: 1fr; }
  }

  @media (max-width: 860px) {
    .performer-create-listing .page { padding: 14px; }
    .performer-create-listing .form-grid,
    .performer-create-listing .upload-grid { grid-template-columns: 1fr; }
    .performer-create-listing .actions-right { width: 100%; }
    .performer-create-listing .actions-right .primary-btn,
    .performer-create-listing .actions-right .outline-btn { flex: 1; min-width: 0; }
  }
</style>

<div class="performer-create-listing">
  <div class="page">
    <section class="content">
      <main class="panel">
        <div class="section-head">
          <div>
            <h2>Разместить новое объявление</h2>
            <p>Форма для исполнителя: сначала базовые параметры услуги, затем материалы, сроки, география и подробное описание. Важные поля выделены, а редкие параметры вынесены в спокойный второй уровень.</p>
          </div>
        </div>

        <div class="form-grid">
          <div class="field full">
            <label>Название объявления или услуги *</label>
            <input class="control" type="text" value="Изготовление металлического каркаса по чертежам заказчика" />
          </div>

          <div class="field">
            <label>Категория *</label>
            <div class="select-wrap">
              <div class="select">Металлоконструкции</div>
            </div>
          </div>

          <div class="field">
            <label>Бюджет *</label>
            <input class="control" type="text" value="от 15 000 ₽" />
          </div>

          <div class="field full">
            <label>Краткое описание услуги *</label>
            <textarea class="textarea">Изготавливаем металлические каркасы, опорные конструкции и сварные элементы по техническому заданию. Работаем по чертежам, эскизам и DXF-файлам. Возможна подготовка партии под серийное производство.</textarea>
          </div>

          <div class="field full">
            <label>Материалы <span class="optional">необязательно</span></label>
            <div class="combo-wrap">
              <input class="control" type="text" value="Сталь 3 мм, профильная труба 20x20, лист 2 мм" />
              <button class="mini-add" type="button">+</button>
            </div>
            <div class="materials">
              <div class="tag">Сталь 3 мм <span>×</span></div>
              <div class="tag">Лист 2 мм <span>×</span></div>
              <div class="tag">Сварка MIG <span>×</span></div>
            </div>
          </div>

          <div class="field full">
            <label>Местоположение</label>
            <input class="control" type="text" value="Москва, ул. Электродная, 12" />
          </div>

          <div class="field">
            <label>Срок выполнения</label>
            <input class="control" type="text" value="1–2 недели" />
          </div>

          <div class="field">
            <label>Объём выполнения *</label>
            <div class="select-wrap">
              <div class="select">Любой — единичный и серийный</div>
            </div>
          </div>

          <div class="field full">
            <label>Дополнительные условия</label>
            <div class="switch-row">
              <div class="check active"><span class="check-box"></span> Возможность выполнить заказ срочно</div>
              <div class="check"><span class="check-box"></span> Работа по договору</div>
              <div class="check"><span class="check-box"></span> Доступна доставка</div>
            </div>
            <div class="helper">Отметь только то, что реально можешь гарантировать — это повышает доверие и качество откликов.</div>
          </div>

          <div class="field full">
            <label>Подробное описание объявления или услуги</label>
            <textarea class="textarea" style="min-height: 170px;">Подробно опишите, какие виды работ вы берёте, на каком оборудовании работаете, есть ли ограничения по размерам/материалам, как быстро отвечаете на заявки и какие файлы нужны для расчёта. Можно добавить информацию о минимальном заказе, постобработке, упаковке и доставке.</textarea>
          </div>
        </div>

        <div class="actions">
          <div class="actions-left">Поля, отмеченные звёздочкой, обязательны для публикации. После размещения объявление появится в каталоге исполнителей и станет доступно заказчикам для отклика.</div>
          <div class="actions-right">
            <button class="primary-btn" type="button">Разместить объявление</button>
            <button class="outline-btn" type="button">Отмена</button>
          </div>
        </div>
      </main>

      <aside class="sidebar">
        <section class="upload-card">
          <div class="upload-icon">⬆</div>
          <h3>Добавьте файлы и примеры работ</h3>
          <p>Фото, чертежи, DXF, PDF, примеры готовых изделий. Так заказчику проще понять, что именно вы делаете и какого качества ожидать.</p>
          <button class="primary-btn" type="button" style="min-height:54px; min-width: 220px;">Добавить вложения</button>
        </section>

        <section class="upload-grid">
          <div class="thumb"><div class="thumb-bar"><span>Каркас_01.jpg</span><span>Удалить</span></div></div>
          <div class="thumb"><div class="thumb-bar"><span>Сварка_деталь.png</span><span>Удалить</span></div></div>
          <div class="thumb"><div class="thumb-bar"><span>Чертёж_A3.pdf</span><span>Удалить</span></div></div>
        </section>

        <section class="sidebar-card">
          <h3>Что важно показать</h3>
          <ul>
            <li>Какие материалы и типы заказов берёшь в работу.</li>
            <li>Срок, в который реально можешь стартовать и завершить задачу.</li>
            <li>Наличие собственного оборудования или производства.</li>
            <li>Возможность срочного выполнения, доставки и закрывающих документов.</li>
          </ul>
        </section>

        <section class="sidebar-card">
          <h3>Статус объявления</h3>
          <p>Блок справа помогает быстро проверить, всё ли готово перед публикацией.</p>
          <div class="status-list">
            <div class="status-item"><span>Основные поля</span><span>Заполнено</span></div>
            <div class="status-item"><span>Описание услуги</span><span>Готово</span></div>
            <div class="status-item"><span>Прикрепления</span><span>3 файла</span></div>
            <div class="status-item"><span>Проверка перед публикацией</span><span>Осталось 1 шаг</span></div>
          </div>
        </section>
      </aside>
    </section>
  </div>
</div>
@endsection