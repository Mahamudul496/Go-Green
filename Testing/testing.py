from selenium import webdriver
from selenium.webdriver.edge.service import Service
from selenium.webdriver.common.by import By

options = webdriver.EdgeOptions()
options.add_experimental_option("detach", True)

service_object = Service()
driver = webdriver.Edge(service=service_object, options=options)

driver.get("https://decode-cadillac-dimly.ngrok-free.dev/Go-Green/")

driver.find_element(By.CSS_SELECTOR,"body > section.hero > div > div.hero-text > div > a:nth-child(1)").click()
driver.find_element(By.CSS_SELECTOR,"body > div > div > a:nth-child(1)").click()
driver.find_element(By.CSS_SELECTOR,"body > form > div > input[type=email]:nth-child(2)").send_keys("mahmudulmidul@gmail.com")
driver.find_element(By.CSS_SELECTOR,"body > form > div > input[type=password]:nth-child(3)").send_keys("1234")
driver.find_element(By.CSS_SELECTOR,"body > form > div > button").click()
driver.find_element(By.CSS_SELECTOR,"body > nav > ul > li:nth-child(3) > a").click()

driver.find_element(By.CSS_SELECTOR,"body > div.container > div.cards > a:nth-child(1) > div > div.card-footer").click()
driver.find_element(By.CSS_SELECTOR,"body > div.container > div.products > div:nth-child(2) > form > button").click()
driver.find_element(By.CSS_SELECTOR,"body > div.navbar > div.nav-links > div > a").click()

msg = driver.find_element(By.CSS_SELECTOR,"body > div > div.notifications").text
print(msg)







