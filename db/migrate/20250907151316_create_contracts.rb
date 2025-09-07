class CreateContracts < ActiveRecord::Migration[8.0]
  def change
    create_table :contracts do |t|
      t.string :contract_code
      t.references :room, null: false, foreign_key: true
      t.references :customer, null: false, foreign_key: true
      t.decimal :deposit
      t.datetime :start_date
      t.datetime :end_date

      t.timestamps
    end
  end
end
