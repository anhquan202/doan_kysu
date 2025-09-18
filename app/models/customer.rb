class Customer < ApplicationRecord
  has_one :vehicle, dependent: :destroy
  has_many :contract_customers, dependent: :destroy

  validates :identity_code, length: { minimum: 12, maximum: 12 }, presence: true
  validates :first_name, length: { minimum: 2 }, presence: true
  validates :last_name, length: { minimum: 2 }, presence: true
  validates :address, presence: true
  validates :phone_number, presence: true
  validates :gender, presence: true

  enum :gender, { male: 1, female: 2, other: 3 }
  enum :status, { active: 1, inactive: 2 }, default: :active

  def full_name
    "#{first_name} #{last_name}"
  end
end
