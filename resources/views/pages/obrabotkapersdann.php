<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Обработка персональных данных</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <style>
  
:root {
  --bg: #f5f7fa;
  --card: #ffffff;
  --line: #e8edf2;

  --text: #111827;
  --muted: #6b7280;

  --accent: #111827;

  --radius: 26px;
  --container: 1120px;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  background: var(--bg);
  color: var(--text);

  font-family: 'Inter', sans-serif;
  line-height: 1.7;
  overflow-x: hidden;
}

/* PAGE */
.policy-page {
  position: relative;
  min-height: 100vh;
  padding: 140px 24px 80px;

  background:
    radial-gradient(circle at top right,
      rgba(17, 24, 39, 0.04),
      transparent 30%);
}

/* GRID BACKGROUND */
.policy-bg {
  position: absolute;
  inset: 0;
  z-index: 0;
  overflow: hidden;
}

.policy-bg::after {
  content: '';
  position: absolute;
  inset: 0;

  background-image:
    linear-gradient(rgba(17,24,39,0.035) 1px, transparent 1px),
    linear-gradient(90deg, rgba(17,24,39,0.035) 1px, transparent 1px);

  background-size: 54px 54px;
}

/* CONTAINER */
.policy-container {
  position: relative;
  z-index: 2;

  width: 100%;
  max-width: var(--container);
  margin: 0 auto;
}

/* TOP */
.policy-top {
  margin-bottom: 72px;
}

.policy-label {
  display: inline-flex;
  align-items: center;
  gap: 10px;

  padding: 8px 16px;
  margin-bottom: 28px;

  border-radius: 999px;
  border: 1px solid var(--line);

  background: rgba(255,255,255,0.7);
  backdrop-filter: blur(10px);

  font-size: .72rem;
  font-weight: 700;
  letter-spacing: .16em;
  text-transform: uppercase;

  color: #4b5563;
}

.policy-label::before {
  content: '';

  width: 6px;
  height: 6px;

  border-radius: 50%;
  background: #111827;
}

.policy-title {
  max-width: 920px;

  margin-bottom: 24px;

  font-size: clamp(3rem, 8vw, 6rem);
  line-height: .92;
  letter-spacing: -.05em;
  font-weight: 900;

  color: #111827;
}

.policy-subtitle {
  max-width: 760px;

  font-size: 1.05rem;
  line-height: 1.8;

  color: var(--muted);
}

/* CARD */
.policy-card {
  background: var(--card);

  border: 1px solid var(--line);
  border-radius: var(--radius);

  padding: 56px;

  box-shadow:
    0 10px 40px rgba(15, 23, 42, 0.04),
    0 2px 8px rgba(15, 23, 42, 0.03);
}

/* SECTIONS */
.policy-section + .policy-section {
  margin-top: 54px;
  padding-top: 54px;

  border-top: 1px solid var(--line);
}

.policy-section h2 {
  margin-bottom: 22px;

  font-size: 1.45rem;
  font-weight: 800;
  letter-spacing: -.02em;

  color: #111827;
}

.policy-section p {
  margin-bottom: 18px;

  color: #4b5563;
}

.policy-section ul {
  display: flex;
  flex-direction: column;
  gap: 14px;

  padding-left: 18px;
}

.policy-section li {
  color: #4b5563;
}

/* CONTACT */
.policy-contact {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 20px;

  margin-top: 28px;
}

.policy-contact-item {
  padding: 22px;

  border-radius: 18px;
  border: 1px solid var(--line);

  background: #fafbfc;
}

.policy-contact-label {
  display: block;

  margin-bottom: 8px;

  font-size: .72rem;
  font-weight: 700;
  letter-spacing: .14em;
  text-transform: uppercase;

  color: #9ca3af;
}

.policy-contact-value {
  font-size: .98rem;
  font-weight: 500;

  color: #111827;
}

/* FOOTER */
.policy-footer {
  margin-top: 52px;
  padding-top: 28px;

  border-top: 1px solid var(--line);

  font-size: .92rem;
  color: #9ca3af;
}

/* MOBILE */
@media (max-width: 768px) {

  .policy-page {
    padding-top: 110px;
  }

  .policy-card {
    padding: 28px;
    border-radius: 22px;
  }

  .policy-contact {
    grid-template-columns: 1fr;
  }

  .policy-title {
    font-size: clamp(2.4rem, 13vw, 4rem);
  }

}


  </style>
</head>

<body>

  <section class="policy-page">

    <div class="policy-bg"></div>

    <div class="policy-container">

      <div class="policy-top">

        <div class="policy-label">
          Юридическая информация
        </div>

        <h1 class="policy-title">
          Обработка персональных данных
        </h1>

        <p class="policy-subtitle">
          Настоящая политика определяет порядок обработки и защиты
          персональных данных пользователей фитнес-клуба «Авангард»
          в соответствии с требованиями законодательства Российской Федерации.
        </p>

      </div>

      <div class="policy-card">

        <div class="policy-section">
          <h2>1. Общие положения</h2>

          <p>
            Настоящая политика обработки персональных данных составлена
            в соответствии с Федеральным законом РФ №152-ФЗ
            «О персональных данных» и определяет порядок обработки
            персональных данных и меры по обеспечению безопасности
            персональных данных.
          </p>

          <p>
            Оператор ставит своей важнейшей целью соблюдение прав
            и свобод человека и гражданина при обработке его
            персональных данных.
          </p>
        </div>

        <div class="policy-section">
          <h2>2. Какие данные мы собираем</h2>

          <ul>
            <li>ФИО пользователя</li>
            <li>Номер телефона</li>
            <li>Адрес электронной почты</li>
            <li>Дата рождения</li>
            <li>Информация об использовании сайта</li>
            <li>IP-адрес и технические данные устройства</li>
          </ul>
        </div>

        <div class="policy-section">
          <h2>3. Цели обработки данных</h2>

          <ul>
            <li>Регистрация и обслуживание клиентов</li>
            <li>Предоставление доступа к сервисам сайта</li>
            <li>Обратная связь с пользователем</li>
            <li>Информирование об услугах и акциях</li>
            <li>Улучшение качества обслуживания</li>
          </ul>
        </div>

        <div class="policy-section">
          <h2>4. Защита персональных данных</h2>

          <p>
            Оператор принимает необходимые организационные
            и технические меры для защиты персональных данных
            от неправомерного доступа, изменения, раскрытия
            или уничтожения.
          </p>

          <p>
            Доступ к персональным данным имеют только уполномоченные лица,
            обязанные соблюдать конфиденциальность информации.
          </p>
        </div>

        <div class="policy-section">
          <h2>5. Права пользователя</h2>

          <ul>
            <li>Получать информацию об обработке своих данных</li>
            <li>Требовать уточнения или удаления данных</li>
            <li>Отозвать согласие на обработку данных</li>
            <li>Обжаловать действия оператора</li>
          </ul>
        </div>

        <div class="policy-section">
          <h2>6. Контактная информация</h2>

          <div class="policy-contact">

            <div class="policy-contact-item">
              <span class="policy-contact-label">Фитнес-клуб</span>
              <div class="policy-contact-value">
                Авангард
              </div>
            </div>

            <div class="policy-contact-item">
              <span class="policy-contact-label">Адрес</span>
              <div class="policy-contact-value">
                г. Челябинск, ул. Труда, 181
              </div>
            </div>

            <div class="policy-contact-item">
              <span class="policy-contact-label">Email</span>
              <div class="policy-contact-value">
                info@avangard-fitness.ru
              </div>
            </div>

            <div class="policy-contact-item">
              <span class="policy-contact-label">Телефон</span>
              <div class="policy-contact-value">
                +7 (900) 000-00-00
              </div>
            </div>

          </div>
        </div>

        <div class="policy-footer">
          Последнее обновление: 11 мая 2026 г.
        </div>

      </div>

    </div>

  </section>

</body>
</html>